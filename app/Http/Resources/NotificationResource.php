<?php

namespace App\Http\Resources;

use App\Models\Defect;
use App\Models\Project;
use App\Models\SiteDiary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $message = '';
        switch ($this->data['type']) {
            case 'defect_changed':
                $message = optional(Defect::find($this->data['model']))->title . ' Defect is changed';
                break;

            case 'defect_created':
                $message = optional(Defect::find($this->data['model']))->title . ' Defect is created';
                break;

            case 'project_created':
                $message = optional(Project::find($this->data['model']))->name . ' Project is created';
                break;

            case 'project_user_created':
                $message = 'You have been added to a new project ' . optional(Project::find($this->data['model']))->name;
                break;

            case 'sitediary_changed':
                $message = optional(SiteDiary::find($this->data['model']))->name . ' Site Diary is changed';
                break;

            case 'sitediary_comment_created':
                $message = optional(SiteDiary::find($this->data['model']))->name . ' Site Diary has a new comment';
                break;

            case 'sitediary_created':
                $message = optional(SiteDiary::find($this->data['model']))->name . ' Site Diary is created';
                break;
        }

        return [
            'id'         => $this->id,
            'type'       => $this->data['type'],
            'icon'       => $this->data['icon'],
            'message'    => $message,
            'read_at'    => $this->read_at,
            'created_at' => $this->created_at
        ];
    }
}
