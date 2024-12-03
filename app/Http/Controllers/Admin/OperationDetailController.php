<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\OperationDetail;
use Illuminate\Http\Request;

class OperationDetailController extends Controller
{
    public function index(Operation $operation)
    {
        $details = $operation->details()->paginate(10);
        return view('admin.operation_details.index', compact('operation', 'details'));
    }

    public function create(Operation $operation)
    {
        return view('admin.operation_details.create', compact('operation'));
    }

    public function store(Request $request, Operation $operation)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $operation->details()->create($validated);

        return redirect()->route('admin.operations.details.index', $operation)
            ->with('success', 'Operation detail added successfully!');
    }

    public function edit(Operation $operation, OperationDetail $detail)
    {
        return view('admin.operation_details.edit', compact('detail'));
    }

    public function update(Request $request, Operation $operation, OperationDetail $detail)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $detail->update($validated);

        return redirect()->route('admin.operations.details.index', $operation->id)
            ->with('success', 'Operation detail updated successfully!');
    }

    public function destroy(Operation $operation, OperationDetail $detail)
    {
        $detail->delete();

        return redirect()->route('admin.operations.details.index', $operation->id)
            ->with('success', 'Operation detail deleted successfully!');
    }
}
