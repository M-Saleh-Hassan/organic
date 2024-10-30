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
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'email'       => $this->email,
            'image'       => $this->profile_image,
            'phone'       => $this->phone,
            'company'     => $this->company,
            'position'    => $this->position,
            'role'        => $this->role->name,
            'permissions' => RoleResource::collection($this->permissions),
            'token'       => $this->createToken('auth-token', $this->permissions()->pluck('name')->toArray())->plainTextToken
        ];
    }
}
