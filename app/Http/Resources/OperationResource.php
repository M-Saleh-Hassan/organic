<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
{
    public function toArray($request)
    {
        // Grouping details by type
        $pastOperations = $this->details->where('type', 'past')->values();
        $currentOperations = $this->details->where('type', 'current')->values();
        $futureOperations = $this->details->where('type', 'future')->values();

        return [
            'id' => $this->id,
            'description' => $this->description,
            'past_operations' => $pastOperations->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'description' => $detail->description,
                    'order' => $detail->order,
                ];
            }),
            'current_operations' => $currentOperations->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'description' => $detail->description,
                    'order' => $detail->order,
                ];
            }),
            'future_operations' => $futureOperations->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'description' => $detail->description,
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
