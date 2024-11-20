<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\LandResource;
use App\Models\Land;
use Illuminate\Http\Request;

class LandController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $lands = Land::with('user')->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']); // Eager load user relationship
        return $this->handlePaginateResponse(LandResource::collection($lands));
    }

    public function show(Land $land)
    {
        $land->load('user'); // Ensure user relationship is loaded
        return $this->handleResponse(new LandResource($land));
    }
}
