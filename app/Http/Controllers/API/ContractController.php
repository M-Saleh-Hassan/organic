<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $contracts = Contract::with(['user', 'land'])->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);
        return $this->handlePaginateResponse(ContractResource::collection($contracts));
    }

    public function show(Contract $contract)
    {
        $contract->load(['user', 'land']);
        return $this->handleResponse(new ContractResource($contract));
    }

    public function store(Request $request)
    {
        // Store the files in the public/contracts folder
        $sponsorshipContractPath = $request->file('sponsorship_contract')->move(public_path('contracts'), uniqid() . '_sponsorship.pdf');
        $participationContractPath = $request->file('participation_contract')->move(public_path('contracts'), uniqid() . '_participation.pdf');
        $personalIdPath = $request->file('personal_id')->move(public_path('contracts'), uniqid() . '_personal_id.pdf');

        // Create the contract entry
        $contract = Contract::create([
            'user_id' => $request->user_id,
            'land_id' => $request->land_id,
            'sponsorship_contract_path' => basename($sponsorshipContractPath),
            'participation_contract_path' => basename($participationContractPath),
            'personal_id_path' => basename($personalIdPath),
        ]);

        return new ContractResource($contract);
    }
}
