<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FloorPlan\IndexFloorPlanRequest;
use App\Http\Requests\FloorPlan\StoreFloorPlanRequest;
use App\Http\Requests\FloorPlan\StoreFloorPlanVersionRequest;
use App\Http\Requests\FloorPlan\UpdateFloorPlanRequest;
use App\Http\Resources\FloorPlanResource;
use App\Http\Resources\FloorPlanVersionResource;
use App\Models\Project;
use App\Models\FloorPlan;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class FloorPlanController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'authorized:floor_plans',
        ];
    }

    public function index(IndexFloorPlanRequest $request, Project $project)
    {
        $filters = $this->getFilters($request);
        $floorPlans = $project->floorPlans()->search($filters['search'])
            ->parent()
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(FloorPlanResource::collection($floorPlans));
    }

    public function show(Project $project, FloorPlan $floorPlan)
    {
        return $this->handleResponse(new FloorPlanResource($floorPlan));
    }

    public function store(StoreFloorPlanRequest $request, Project $project)
    {
        $floorPlansIds = [];
        foreach ($request->file('floor_plans') as $key => $file) {
            $file = $file['file'];
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $fileHandler = App::make(FileHandlerInterface::class);
            $path = $fileHandler->upload($file, $fileName, [
                'folder' => 'Tenants/' . $request->user()->tenant->id . '/Projects/' . $project->id . '/FloorPlans'
            ]);

            $floorPlan = $project->floorPlans()->create([
                'user_id' => $request->user()->id,
                'name'    => $request->floor_plans[$key]['name'],
                'url'     => $path
            ]);
            $floorPlansIds[] = $floorPlan->id;
        }

        return $this->handleResponse(FloorPlanResource::collection(FloorPlan::find($floorPlansIds)));
    }

    public function update(UpdateFloorPlanRequest $request, Project $project, FloorPlan $floorPlan)
    {
        $floorPlan->update([
            'name'    => $request->name,
        ]);

        return $this->handleResponse(new FloorPlanResource($floorPlan));
    }

    public function destroy(IndexFloorPlanRequest $request, Project $project, FloorPlan $floorPlan)
    {
        foreach ($floorPlan->floorPlans as $floorPlanVersion) {
            Storage::delete($floorPlanVersion->url);
            $floorPlanVersion->delete();
        }
        Storage::delete($floorPlan->url);
        $floorPlan->delete();
        return $this->handleResponseMessage('Floor Plan deleted successfully');
    }

    public function getVersions(Request $request, FloorPlan $floorPlan)
    {
        $filters = $this->getFilters($request);
        $floorPlans = $floorPlan->floorPlans()->search($filters['search'])
            ->includingMainParent($floorPlan->id)
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(FloorPlanVersionResource::collection($floorPlans));
    }

    public function storeVersion(StoreFloorPlanVersionRequest $request, FloorPlan $floorPlan)
    {
        $file = $request->file('file');
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $fileHandler = App::make(FileHandlerInterface::class);
        $path = $fileHandler->upload($file, $fileName, [
            'folder' => 'Tenants/' . $request->user()->tenant->id . '/Projects/' . $floorPlan->project->id . '/FloorPlans'
        ]);

        $floorPlan = $floorPlan->floorPlans()->create([
            'project_id' => $floorPlan->project->id,
            'user_id'    => $request->user()->id,
            'name'       => $request->name,
            'url'        => $path
        ]);

        return $this->handleResponse(new FloorPlanResource($floorPlan));
    }
}
