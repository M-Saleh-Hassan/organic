<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteDiaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'description'    => $this->description,
            'weather'        => new WeatherResource($this->weather),
            'equipments'     => EquipmentResource::collection($this->equipments),
            'staff'          => SiteDiaryStaffResource::collection($this->staff),
            'images'         => FileResource::collection($this->images),
            'comments'       => SiteDiaryCommentResource::collection($this->comments),
            'watch_comments' => $this->userWatchComments()->whereUserId(auth()->user()->id)->exists(),
            'created_at'     => $this->created_at
        ];
    }
}
