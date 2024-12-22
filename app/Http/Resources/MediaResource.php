<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'full_name' => $this->user->full_name,
            ],
            'land' => [
                'id' => $this->land->id,
                'land_number' => $this->land->land_number,
            ],
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'file_path' => Storage::url($image->file_path),
                    'date' => $image->date,
                ];
            }),
            'videos' => $this->videos->map(function ($video) {
                return [
                    'id' => $video->id,
                    'file_path' => Storage::url($video->file_path),
                    'date' => $video->date,
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
