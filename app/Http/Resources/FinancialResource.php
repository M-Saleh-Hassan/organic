<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_url' => asset('financials/' . $this->file_path), // Generate full file URL
            'records' => $this->records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'month' => $record->month,
                    'date' => $record->date ? $record->date : null,
                    'amount' => $record->amount,
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
