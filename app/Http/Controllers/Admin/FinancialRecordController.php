<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;

class FinancialRecordController extends Controller
{
    public function index(Financial $financial)
    {
        $records = $financial->records()->paginate(10);
        return view('admin.financial_records.index', compact('financial', 'records'));
    }

    public function create(Financial $financial)
    {
        return view('admin.financial_records.create', compact('financial'));
    }

    public function store(Request $request, Financial $financial)
    {
        $validated = $request->validate([
            'month' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        $financial->records()->create($validated);

        return redirect()->route('admin.financials.records.index', $financial)
            ->with('success', 'Financial record added successfully!');
    }

    public function edit(Financial $financial, FinancialRecord $record)
    {
        return view('admin.financial_records.edit', compact('record'));
    }

    public function update(Request $request, Financial $financial, FinancialRecord $record)
    {
        $validated = $request->validate([
            'month' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        $record->update($validated);

        return redirect()->route('admin.financials.records.index', $record->financial_id)
            ->with('success', 'Financial record updated successfully!');
    }

    public function destroy(Financial $financial, FinancialRecord $record)
    {
        $record->delete();

        return redirect()->route('admin.financials.records.index', $financial->id)
            ->with('success', 'Financial record deleted successfully!');
    }
}

