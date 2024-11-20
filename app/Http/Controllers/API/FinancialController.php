<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\FinancialResource;
use App\Models\Financial;
use Illuminate\Http\Request;

class FinancialController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $financials = Financial::with(['user', 'land', 'records'])
            ->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(FinancialResource::collection($financials));
    }

    public function show(Financial $financial)
    {
        $financial->load(['user', 'land', 'records']);
        return $this->handleResponse(new FinancialResource($financial));
    }

    public function store(Request $request)
    {
        // Store the file in the public/financials directory
        $filePath = $request->file('file_path')->store('financials', 'public');

        $financial = Financial::create([
            'user_id' => $request->user_id,
            'land_id' => $request->land_id,
            'file_path' => $filePath,
        ]);

        // Add financial records
        foreach ($request->records as $record) {
            $financial->records()->create($record);
        }

        return $this->handleResponse(new FinancialResource($financial));
    }
}
