<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'assigned_projects' => RoleResource::collection($this->projects),
            'created_at'  => $this->created_at
        ];
    }
}
