<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreOperationRequest;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $operations = Operation::with(['user', 'land', 'details'])
            ->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(OperationResource::collection($operations));
    }

    public function show(Operation $operation)
    {
        $operation->load(['user', 'land', 'details']);
        return $this->handleResponse(new OperationResource($operation));
    }

    public function store(Request $request)
    {
        $operation = Operation::create($request->only('user_id', 'land_id', 'description'));

        $operation->details()->create([
            'type' => $request->type,
            'description' => $request->detail_description,
            'date' => $request->date,
            'order' => $request->order,
        ]);

        return $this->handleResponse(new OperationResource($operation));
    }
}
