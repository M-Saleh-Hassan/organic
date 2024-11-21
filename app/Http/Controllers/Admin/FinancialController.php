<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function index()
    {
        $financials = Financial::with('user', 'land')->paginate(10);
        return view('admin.financials.index', compact('financials'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        $lands = Land::all();
        return view('admin.financials.create', compact('users', 'lands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'file_path' => 'required|file|mimes:xls,xlsx|max:10240',
        ]);

        $filePath = $request->file('file_path')->store('financials', 'public');
        Financial::create([
            'user_id' => $validated['user_id'],
            'land_id' => $validated['land_id'],
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.financials.index')->with('success', 'Financial record created successfully!');
    }

    public function edit(Financial $financial)
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.financials.edit', compact('financial', 'users', 'lands'));
    }

    public function update(Request $request, Financial $financial)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
            'file_path' => 'nullable|file|mimes:xls,xlsx|max:10240',
        ]);

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('financials', 'public');
            $financial->file_path = $filePath;
        }

        $financial->update([
            'user_id' => $validated['user_id'],
            'land_id' => $validated['land_id'],
        ]);

        return redirect()->route('admin.financials.index')->with('success', 'Financial record updated successfully!');
    }

    public function destroy(Financial $financial)
    {
        $financial->delete();
        return redirect()->route('admin.financials.index')->with('success', 'Financial record deleted successfully!');
    }
}
