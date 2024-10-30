<?php

namespace App\Http\Resources;

use App\Models\Defect;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'overdue_defects'   => Defect::where('due_date', '<', now())->count(),
            'total_defects'     => $this->defects()->count(),
            'assigned_projects' => auth()->user()->projects()->count(),
            'defects' => [
                'in_progress' => DefectResource::collection($this->defects()->notStatus('Closed')->limit(10)->latest()->get()),
                'resolved'    => DefectResource::collection($this->defects()->status('Closed')->limit(10)->latest()->get()),
            ],
            'defects_count' => [
                'open'        => $this->defects()->status('Open')->count(),
                'in_progress' => $this->defects()->status('In Progress')->count(),
                'resolved'    => $this->defects()->status('Closed')->count(),
            ],
            'site_diaries' => SiteDiaryResource::collection($this->siteDiaries()->limit(10)->latest()->get()),
        ];
    }
}
