<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DefectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'due_date'    => $this->due_date,
            'work_type'   => $this->work_type,
            'status'      => $this->status,

            'assignee'    => new UserDropDownResource($this->assignee),
            'floorPlan'   => new FloorPlanResource($this->floorPlan),
            'locations'   => LocationResource::collection($this->locations),
            'attachments' => DefectAttachmentResource::collection($this->attachments),
            'created_at'  => $this->created_at
        ];
    }
}
