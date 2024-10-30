<?php

namespace App\Http\Resources;

use App\Models\Defect;
use App\Models\SiteDiary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportDataResource extends JsonResource
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
            'name'        => $this->name,
            'report_type' => $reportType,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'created_at'  => $this->created_at
        ];

        if ($reportType == 'diary') {
            $diaries = SiteDiary::createdBetween($this->start_date, $this->end_date)->get();
            $resource['diaries'] = SiteDiaryResource::collection($diaries);
        } elseif ($reportType == 'defect') {
            $defects = Defect::createdBetween($this->start_date, $this->end_date)->forAssignee($this->subcontractor_id)->get();
            $resource['defects'] = DefectResource::collection($defects);
        }
        return $resource;
    }
}
