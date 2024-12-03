<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['user', 'land'])->paginate(10);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.contracts.create', compact('users', 'lands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'sponsorship_contract' => 'required|file|mimes:pdf|max:2048',
            'participation_contract' => 'required|file|mimes:pdf|max:2048',
            'personal_id' => 'required|file|max:2048',
        ]);

        $sponsorshipContractPath = $request->file('sponsorship_contract')->store('contracts', 'public');
        $participationContractPath = $request->file('participation_contract')->store('contracts', 'public');
        $personalIdPath = $request->file('personal_id')->store('contracts', 'public');

        Contract::create([
            'user_id' => $validated['user_id'],
            'land_id' => $validated['land_id'],
            'sponsorship_contract_path' => $sponsorshipContractPath,
            'participation_contract_path' => $participationContractPath,
            'personal_id_path' => $personalIdPath,
        ]);

        return redirect()->route('admin.contracts.index')->with('success', 'Contract created successfully!');
    }

    public function show(Contract $contract)
    {
        $contract->load(['user', 'land']);
        return view('admin.contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.contracts.edit', compact('contract', 'users', 'lands'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'sponsorship_contract' => 'nullable|file|mimes:pdf|max:2048',
            'participation_contract' => 'nullable|file|mimes:pdf|max:2048',
            'personal_id' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('sponsorship_contract')) {
            Storage::disk('public')->delete($contract->sponsorship_contract_path);
            $contract->sponsorship_contract_path = $request->file('sponsorship_contract')->store('contracts', 'public');
        }

        if ($request->hasFile('participation_contract')) {
            Storage::disk('public')->delete($contract->participation_contract_path);
            $contract->participation_contract_path = $request->file('participation_contract')->store('contracts', 'public');
        }

        if ($request->hasFile('personal_id')) {
            Storage::disk('public')->delete($contract->personal_id_path);
            $contract->personal_id_path = $request->file('personal_id')->store('contracts', 'public');
        }

        $contract->update([
            'user_id' => $validated['user_id'],
            'land_id' => $validated['land_id'],
        ]);

        return redirect()->route('admin.contracts.index')->with('success', 'Contract updated successfully!');
    }

    public function destroy(Contract $contract)
    {
        Storage::disk('public')->delete($contract->sponsorship_contract_path);
        Storage::disk('public')->delete($contract->participation_contract_path);
        Storage::disk('public')->delete($contract->personal_id_path);

        $contract->delete();

        return redirect()->route('admin.contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
