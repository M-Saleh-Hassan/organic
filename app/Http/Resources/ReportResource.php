<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reportType = $this->report_type;
        $resource = [
            'id'          => $this->id,
            'user'        => new UserDropDownResource($this->user),
            'name'        => $this->name,
            'report_type' => $reportType,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'created_at'  => $this->created_at
        ];
        if($reportType == 'defect') {
            $resource['subcontractors'] = UserDropDownResource::collection($this->subcontractors);
            $resource['floor_plan']     = new FloorPlanResource($this->floorPlan);
        }
        return $resource;
    }
}
