<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index()
    {
        $operations = Operation::with(['user', 'land'])->paginate(10);
        return view('admin.operations.index', compact('operations'));
    }

    public function create()
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.operations.create', compact('users', 'lands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'description' => 'nullable|string',
        ]);

        Operation::create($validated);

        return redirect()->route('admin.operations.index')->with('success', 'Operation created successfully!');
    }

    public function edit(Operation $operation)
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.operations.edit', compact('operation', 'users', 'lands'));
    }

    public function update(Request $request, Operation $operation)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'description' => 'nullable|string',
        ]);

        $operation->update($validated);

        return redirect()->route('admin.operations.index')->with('success', 'Operation updated successfully!');
    }

    public function destroy(Operation $operation)
    {
        $operation->delete();

        return redirect()->route('admin.operations.index')->with('success', 'Operation deleted successfully!');
    }
}
