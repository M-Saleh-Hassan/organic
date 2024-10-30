<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Project\DestroyProjectRequest;
use App\Http\Requests\Project\ShowProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\WeatherResource;
use App\Models\City;
use App\Models\Country;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use App\Notifications\ProjectUserCreatedNotification;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class ProjectController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'authorized:projects',
        ];
    }

    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $projects = Project::search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(ProjectResource::collection($projects));
    }

    public function show(ShowProjectRequest $request, Project $project)
    {
        return $this->handleResponse(new ProjectResource($project));
    }

    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();
        $project = Project::create($request->validated() + [
            'user_id' => $request->user()->id,
            'code'    => Project::generateUniqueCode()
        ]);

        if ($request->has('city_id')) {
            $city = City::find($request->city_id);
            $project->update([
                'city_id'    => $city->id,
                'country_id' => $city->country->id,
            ]);
        }

        if ($request->has('users')) {
            $project->users()->attach($request->users);
        }

        if ($request->has('floor_plans')) {
            foreach ($request->file('floor_plans') as $key => $file) {
                $file = $file['file'];
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileHandler = App::make(FileHandlerInterface::class);
                $path = $fileHandler->upload($file, $fileName, [
                    'folder' => 'Tenants/' . $request->user()->tenant->id . '/Projects/' . $project->id . '/FloorPlans'
                ]);

                $project->floorPlans()->create([
                    'user_id' => $request->user()->id,
                    'name'    => $request->floor_plans[$key]['name'],
                    'url'     => $path
                ]);
            }
        }
        DB::commit();
        foreach ($project->users as $user) {
            $user->notify(new ProjectCreatedNotification($project));
        }
        return $this->handleResponse(new ProjectResource($project));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();
        $project->update($request->validated());

        if ($request->has('users')) {
            $toBeNotifiedUsers = array_diff($request->users, $project->users->pluck('id')->toArray());
            $project->users()->sync($request->users);
        }

        if ($request->has('city_id')) {
            $city = City::find($request->city_id);
            $project->update([
                'city_id'    => $city->id,
                'country_id' => $city->country->id,
            ]);
        }

        DB::commit();

        foreach ($toBeNotifiedUsers as $toBeNotifiedUser) {
            User::find($toBeNotifiedUser)->notify(new ProjectUserCreatedNotification($project));
        }
        return $this->handleResponse(new ProjectResource($project));
    }

    public function destroy(DestroyProjectRequest $request, Project $project)
    {
        foreach ($project->floorPlans as $floorPlan) {
            Storage::delete($floorPlan->url);
        }
        $project->delete();
        return $this->handleResponseMessage('Project deleted successfully');
    }

    public function getCountries(Request $request)
    {
        $filters = $this->getFilters($request);
        $countries = Country::search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($request->has('limit') ? $filters['limit'] : 100000);

        return $this->handlePaginateResponse(RoleResource::collection($countries));
    }

    public function getCities(Request $request, Country $country)
    {
        $filters = $this->getFilters($request);
        $cities = City::where('country_id', $country->id)
            ->search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($request->has('limit') ? $filters['limit'] : 100000);

        return $this->handlePaginateResponse(RoleResource::collection($cities));
    }

    public function getProjectWeather(Project $project)
    {
        return $this->handleResponse(new WeatherResource($project->getWeatherData()));
    }
}
