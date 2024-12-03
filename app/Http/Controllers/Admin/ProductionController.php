<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Production;
use App\Models\User;
use App\Models\Land;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::with(['user', 'land'])->paginate(10);
        return view('admin.productions.index', compact('productions'));
    }

    public function create()
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.productions.create', compact('users', 'lands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'description' => 'nullable|string',
        ]);

        Production::create($validated);

        return redirect()->route('admin.productions.index')->with('success', 'Production created successfully!');
    }

    public function edit(Production $production)
    {
        $users = User::all();
        $lands = Land::all();
        $production->load('details');
        return view('admin.productions.edit', compact('production', 'users', 'lands'));
    }

    public function update(Request $request, Production $production)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'description' => 'nullable|string',
        ]);

        $production->update($validated);

        return redirect()->route('admin.productions.index')->with('success', 'Production updated successfully!');
    }

    public function destroy(Production $production)
    {
        $production->details()->delete();
        $production->delete();

        return redirect()->route('admin.productions.index')->with('success', 'Production deleted successfully!');
    }
}
