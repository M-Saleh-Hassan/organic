<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Models\Land;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with(['user', 'land'])->paginate(10);
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        $users = User::all();
        $lands = Land::all();
        return view('admin.media.create', compact('users', 'lands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
        ]);

        Media::create($validated);

        return redirect()->route('admin.media.index')->with('success', 'Media entry created successfully!');
    }

    public function edit(Media $media)
    {
        $users = User::all();
        $lands = Land::all();
        $media->load('images', 'videos');
        return view('admin.media.edit', compact('media', 'users', 'lands'));
    }

    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'land_id' => 'required|exists:lands,id',
        ]);

        $media->update($validated);

        return redirect()->route('admin.media.index')->with('success', 'Media entry updated successfully!');
    }

    public function destroy(Media $media)
    {
        $media->images()->delete();
        $media->videos()->delete();
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media entry deleted successfully!');
    }
}
