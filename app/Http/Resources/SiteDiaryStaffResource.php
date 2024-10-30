<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteDiaryStaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'entry_time' => $this->entry_time,
            'exit_time'  => $this->exit_time,
            'user'       => new UserDropDownResource($this->user),
            'created_at' => $this->created_at,
        ];
    }
}
