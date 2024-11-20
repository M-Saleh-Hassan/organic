<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductionResource;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $productions = Production::with(['user', 'land', 'details'])
            ->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(ProductionResource::collection($productions));
    }

    public function show(Production $production)
    {
        $production->load(['user', 'land', 'details']);
        return $this->handleResponse(new ProductionResource($production));
    }

    public function store(Request $request)
    {
        $production = Production::create($request->validated());

        $production->details()->create([
            'type' => $request->type,
            'text' => $request->text,
            'order' => $request->order,
        ]);

        return $this->handleResponse(new ProductionResource($production));
    }
}
