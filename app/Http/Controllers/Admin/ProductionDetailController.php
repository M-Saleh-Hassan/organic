<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Production;
use App\Models\ProductionDetail;
use Illuminate\Http\Request;

class ProductionDetailController extends Controller
{
    public function index(Production $production)
    {
        $details = $production->details()->paginate(10);
        return view('admin.production_details.index', compact('production', 'details'));
    }

    public function create(Production $production)
    {
        return view('admin.production_details.create', compact('production'));
    }

    public function store(Request $request, Production $production)
    {
        $validated = $request->validate([
            'type' => 'required|in:past,current',
            'text' => 'required|string',
            'order' => 'required|integer|min:0',
        ]);

        $production->details()->create($validated);

        return redirect()->route('admin.productions.details.index', $production)
            ->with('success', 'Production detail added successfully!');
    }

    public function edit(Production $production, ProductionDetail $detail)
    {
        return view('admin.production_details.edit', compact('detail'));
    }

    public function update(Request $request, Production $production, ProductionDetail $detail)
    {
        $validated = $request->validate([
            'type' => 'required|in:past,current',
            'text' => 'required|string',
            'order' => 'required|integer|min:0',
        ]);

        $detail->update($validated);

        return redirect()->route('admin.productions.details.index', $detail->production_id)
            ->with('success', 'Production detail updated successfully!');
    }

    public function destroy(Production $production, ProductionDetail $detail)
    {
        $detail->delete();

        return redirect()->route('admin.productions.details.index', $production->id)
            ->with('success', 'Production detail deleted successfully!');
    }
}
