<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name'        => $this->name,
            'description' => $this->description,
            'code'        => $this->code,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'company'     => $this->company,
            'address'     => $this->address,
            'users'       => UserResource::collection($this->users),
            'floorPlans'  => FloorPlanResource::collection($this->floorPlans),
            'country'     => new RoleResource($this->country),
            'city'        => new RoleResource($this->city),
            'created_at'  => $this->created_at
        ];
    }
}
