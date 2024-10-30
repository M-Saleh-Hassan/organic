<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SiteDiary\IndexSiteDiaryRequest;
use App\Http\Requests\SiteDiary\StoreSiteDiaryCommentRequest;
use App\Http\Requests\SiteDiary\StoreSiteDiaryRequest;
use App\Http\Requests\SiteDiary\UpdateSiteDiaryRequest;
use App\Http\Resources\SiteDiaryCommentResource;
use App\Http\Resources\SiteDiaryResource;
use App\Http\Resources\WeatherResource;
use App\Models\Project;
use App\Models\SiteDiary;
use App\Models\SiteDiaryImage;
use App\Models\User;
use App\Notifications\SiteDiaryChangedNotification;
use App\Notifications\SiteDiaryCommentCreatedNotification;
use App\Notifications\SiteDiaryCreatedNotification;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class SiteDiaryController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'authorized:site_diaries',
        ];
    }

    public function index(IndexSiteDiaryRequest $request, Project $project)
    {
        $filters = $this->getFilters($request);
        $siteDiaries = $project->siteDiaries()->search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(SiteDiaryResource::collection($siteDiaries));
    }

    public function show(Project $project, SiteDiary $siteDiary)
    {
        return $this->handleResponse(new SiteDiaryResource($siteDiary));
    }

    public function store(StoreSiteDiaryRequest $request, Project $project)
    {
        DB::beginTransaction();
        $siteDiary = SiteDiary::create($request->validated() + [
            'user_id' => $request->user()->id,
            'weather' => new WeatherResource($project->getWeatherData(), true)
        ]);

        if ($request->has('staff')) {
            foreach ($request->staff as $userStaff) {
                $siteDiary->staff()->create([
                    'user_id'    => $userStaff['id'],
                    'entry_time' => $userStaff['entry_time'],
                    'exit_time'  => $userStaff['exit_time']
                ]);
            }
        }

        if ($request->has('equipments')) {
            foreach ($request->equipments as $equipment) {
                $siteDiary->equipments()->create([
                    'equipment'    => $equipment,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->images as $file) {
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileHandler = App::make(FileHandlerInterface::class);
                $path = $fileHandler->upload($file, $fileName, [
                    'folder' => 'Tenants/' . $request->user()->tenant->id . '/SiteDiaries/' . $siteDiary->id
                ]);

                $siteDiary->images()->create([
                    'user_id' => $request->user()->id,
                    'name' => $file->getClientOriginalName(),
                    'url'  => $path
                ]);
            }
        }
        DB::commit();
        foreach ($siteDiary->staff as $staff) {
            $staff->user->notify(new SiteDiaryCreatedNotification($siteDiary));
        }
        return $this->handleResponse(new SiteDiaryResource($siteDiary->fresh()));
    }

    public function update(UpdateSiteDiaryRequest $request, Project $project, SiteDiary $siteDiary)
    {
        DB::beginTransaction();
        $siteDiary->update($request->validated());

        if ($request->has('staff')) {
            $deletedStaff = array_diff($siteDiary->staff->pluck('user_id')->toArray(), collect($request->staff)->pluck('id')->toArray());
            $siteDiary->staff()->whereIn('user_id', $deletedStaff)->delete();
        }
        if ($request->has('staff')) {
            foreach ($request->staff as $userStaff) {
                $siteDiary->staff()->updateOrCreate([
                    'user_id'    => $userStaff['id'],
                ],[
                    'entry_time' => $userStaff['entry_time'],
                    'exit_time'  => $userStaff['exit_time']
                ]);
            }
        }

        if ($request->has('equipments')) {
            $deletedEquipments = array_diff($siteDiary->equipments->pluck('equipment')->toArray(), $request->equipments);
            $siteDiary->equipments()->whereIn('equipment', $deletedEquipments)->delete();
            foreach ($request->equipments as $equipment) {
                $siteDiary->equipments()->firstOrCreate([
                    'equipment'    => $equipment,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->images as $file) {
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileHandler = App::make(FileHandlerInterface::class);
                $path = $fileHandler->upload($file, $fileName, [
                    'folder' => 'Tenants/' . $request->user()->tenant->id . '/SiteDiaries/' . $siteDiary->id
                ]);

                $siteDiary->images()->create([
                    'user_id' => $request->user()->id,
                    'name' => $file->getClientOriginalName(),
                    'url'  => $path
                ]);
            }
        }

        DB::commit();
        foreach ($siteDiary->staff as $staff) {
            $staff->user->notify(new SiteDiaryChangedNotification($siteDiary));
        }
        return $this->handleResponse(new SiteDiaryResource($siteDiary->fresh()));
    }

    public function destroy(IndexSiteDiaryRequest $request, Project $project, SiteDiary $siteDiary)
    {
        foreach ($siteDiary->images as $image) {
            Storage::delete($image->url);
        }
        $siteDiary->delete();
        return $this->handleResponseMessage('Site Diary deleted successfully');
    }

    public function destroyImage(SiteDiary $siteDiary, SiteDiaryImage $siteDiaryImage)
    {
        Storage::delete($siteDiaryImage->url);
        $siteDiaryImage->delete();

        return $this->handleResponseMessage('Image deleted successfully');
    }

    public function storeComment(StoreSiteDiaryCommentRequest $request, SiteDiary $siteDiary)
    {
        $comment = $siteDiary->comments()->create($request->validated() + [
            'user_id' => $request->user()->id,
        ]);

        foreach ($siteDiary->staff as $staff) {
            $staff->user->notify(new SiteDiaryCommentCreatedNotification($comment));
        }

        return $this->handleResponse(new SiteDiaryCommentResource($comment->fresh()));
    }

    public function toggleWatchComment(SiteDiary $siteDiary)
    {
        $siteDiary->userWatchComments()->toggle(request()->user()->id);
        return $this->handleResponse(new SiteDiaryResource($siteDiary));
    }
}
