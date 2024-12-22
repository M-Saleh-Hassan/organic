<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->full_name,
            ],
            'land' => [
                'id' => $this->land->id,
                'land_number' => $this->land->land_number,
            ],
            'documents' => [
                'sponsorship_contract_url' => Storage::url( $this->sponsorship_contract_path),
                'participation_contract_url' => Storage::url( $this->participation_contract_path),
                'personal_id_url' => Storage::url( $this->personal_id_path),
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
