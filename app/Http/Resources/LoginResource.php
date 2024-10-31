<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'full_name'    => $this->full_name,
            'email'        => $this->email,
            'id_type'      => $this->id_type,
            'id_number'    => $this->id_number,
            // 'image'        => $this->profile_image,
            'phone_number' => $this->phone_number,
            'token'        => $this->createToken('auth-token')->plainTextToken
        ];
    }
}