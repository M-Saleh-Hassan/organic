<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;

class LandController extends Controller
{
    public function index()
    {
        $lands = Land::with('user')->paginate(10);
        return view('admin.lands.index', compact('lands'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        return view('admin.lands.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_number' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'number_of_pits' => 'required|integer|min:0',
            'number_of_palms' => 'required|integer|min:0',
            'cultivation_count' => 'required|string|max:255',
            'missing_count' => 'required|numeric|min:0',
        ]);

        Land::create($validated);

        return redirect()->route('admin.lands.index')->with('success', 'Land created successfully!');
    }

    public function edit(Land $land)
    {
        $users = User::where('role_id', 2)->get();
        return view('admin.lands.edit', compact('land', 'users'));
    }

    public function update(Request $request, Land $land)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_number' => 'required|string|max:255',
            'size' => 'required|numeric|min:0',
            'number_of_pits' => 'required|integer|min:0',
            'number_of_palms' => 'required|integer|min:0',
            'cultivation_count' => 'required|string|max:255',
            'missing_count' => 'required|numeric|min:0',
        ]);

        $land->update($validated);

        return redirect()->route('admin.lands.index')->with('success', 'Land updated successfully!');
    }

    public function destroy(Land $land)
    {
        $land->delete();

        return redirect()->route('admin.lands.index')->with('success', 'Land deleted successfully!');
    }
}

