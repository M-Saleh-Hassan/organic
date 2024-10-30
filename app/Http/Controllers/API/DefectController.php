<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Defect\IndexDefectRequest;
use App\Http\Requests\Defect\StoreDefectRequest;
use App\Http\Requests\Defect\UpdateDefectRequest;
use App\Http\Resources\DefectResource;
use App\Http\Resources\UserDropDownResource;
use App\Models\Defect;
use App\Models\DefectAttachment;
use App\Models\Project;
use App\Models\User;
use App\Notifications\DefectChangedNotification;
use App\Notifications\DefectCreatedNotification;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DefectController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'authorized:defects',
        ];
    }

    public function index(IndexDefectRequest $request, Project $project)
    {
        $filters = $this->getFilters($request);
        $defects = $project->defects()->search($filters['search'])
            ->status($request->status)
            ->forAssignee($request->assignee_id)
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(DefectResource::collection($defects));
    }

    public function show(Project $project, Defect $defect)
    {
        return $this->handleResponse(new DefectResource($defect));
    }

    public function store(StoreDefectRequest $request, Project $project)
    {
        DB::beginTransaction();
        $defect = Defect::create($request->validated() + [
            'user_id' => $request->user()->id,
        ]);

        if ($request->has('locations')) {
            foreach ($request->locations as $location) {
                $defect->locations()->create([
                    'horizontal' => $location['x'],
                    'vertical'   => $location['y']
                ]);
            }
        }

        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileHandler = App::make(FileHandlerInterface::class);
                $path = $fileHandler->upload($file, $fileName, [
                    'folder' => 'Tenants/' . $request->user()->tenant->id . '/Defects/' . $defect->id
                ]);

                $defect->attachments()->create([
                    'name' => $file->getClientOriginalName(),
                    'url'  => $path
                ]);
            }
        }
        DB::commit();
        $defect->assignee->notify(new DefectCreatedNotification($defect));
        return $this->handleResponse(new DefectResource($defect->fresh()));
    }

    public function update(UpdateDefectRequest $request, Project $project, Defect $defect)
    {
        DB::beginTransaction();
        $defect->update($request->validated());

        if ($request->has('locations')) {
            $defect->locations()->delete();
            foreach ($request->locations as $location) {
                $defect->locations()->create([
                    'horizontal' => $location['x'],
                    'vertical'   => $location['y']
                ]);
            }
        }

        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $fileHandler = App::make(FileHandlerInterface::class);
                $path = $fileHandler->upload($file, $fileName, [
                    'folder' => 'Tenants/' . $request->user()->tenant->id . '/Defects/' . $defect->id
                ]);

                $defect->attachments()->create([
                    'name' => $file->getClientOriginalName(),
                    'url'  => $path
                ]);
            }
        }

        DB::commit();
        $defect->assignee->notify(new DefectChangedNotification($defect));
        return $this->handleResponse(new DefectResource($defect->fresh()));
    }

    public function destroy(IndexDefectRequest $request, Project $project, Defect $defect)
    {
        foreach ($defect->attachments as $attachments) {
            Storage::delete($attachments->url);
        }
        $defect->delete();
        return $this->handleResponseMessage('Defect deleted successfully');
    }

    public function destroyAttachment(Defect $defect, DefectAttachment $defectAttachment)
    {
        Storage::delete($defectAttachment->url);
        $defectAttachment->delete();

        return $this->handleResponseMessage('Attachment deleted successfully');
    }

    public function getUsersfilters(Request $request, Project $project)
    {
        $usersIds = [];
        foreach ($project->defects as $defect) {
           $usersIds[] = $defect->assignee_id;
        }
        $users = User::find(array_unique($usersIds));
        return $this->handleResponseWithCount(UserDropDownResource::collection($users), count($users));
    }


}
