<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductionResource extends JsonResource
{
    public function toArray($request)
    {
        $pastProductions = $this->details->where('type', 'past')->values();
        $currentProductions = $this->details->where('type', 'current')->values();

        return [
            'id' => $this->id,
            'description' => $this->description,
            'past_productions' => $pastProductions->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'text' => $detail->text,
                    'order' => $detail->order,
                ];
            }),
            'current_productions' => $currentProductions->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'text' => $detail->text,
                    'order' => $detail->order,
                ];
            }),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->full_name,
            ],
            'land' => [
                'id' => $this->land->id,
                'land_number' => $this->land->land_number,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
