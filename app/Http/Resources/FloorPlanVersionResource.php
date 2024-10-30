<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FloorPlanVersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = $this->url;
        $name = $this->name;
        if($this->floorPlans()->exists()) {
            $version =$this->floorPlans()->latest()->first();
            $url = $version->url;
            $name = $version->name;
        }
        return [
            'id'          => $this->id,
            'name'        => $name,
            'uploaded_by' => new UserDropDownResource($this->user),
            'url'         => Storage::url($url),
            'created_at'  => $this->created_at
        ];
    }
}
