<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'land_number'       => $this->land_number,
            'size'              => $this->size,
            'number_of_pits'    => $this->number_of_pits,
            'number_of_palms'   => $this->number_of_palms,
            'cultivation_count' => $this->cultivation_count,
            'missing_count'     => $this->missing_count,
            'created_at'        => $this->created_at->toDateTimeString(),
            'updated_at'        => $this->updated_at->toDateTimeString(),
        ];
    }
}
