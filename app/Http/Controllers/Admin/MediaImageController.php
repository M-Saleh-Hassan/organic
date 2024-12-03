<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaImageController extends Controller
{
    public function index(Media $medium)
    {
        $images = $medium->images()->paginate(10);
        return view('admin.media_images.index', compact('medium', 'images'));
    }

    public function create(Media $medium)
    {
        return view('admin.media_images.create', compact('medium'));
    }

    public function store(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'file_path' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'date' => 'required|date',
        ]);

        $filePath = $request->file('file_path')->store('media/images', 'public');
        $validated['file_path'] = $filePath;

        $medium->images()->create($validated);

        return redirect()->route('admin.media.images.index', $medium)
            ->with('success', 'Image added successfully!');
    }

    public function edit(Media $medium, MediaImage $image)
    {
        return view('admin.media_images.edit', compact('image'));
    }

    public function update(Request $request, Media $medium, MediaImage $image)
    {
        $validated = $request->validate([
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'date' => 'required|date',
        ]);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($image->file_path);
            $filePath = $request->file('file_path')->store('media/images', 'public');
            $validated['file_path'] = $filePath;
        }

        $image->update($validated);

        return redirect()->route('admin.media.images.index', $image->media_id)
            ->with('success', 'Image updated successfully!');
    }

    public function destroy(Media $medium, MediaImage $image)
    {
        Storage::disk('public')->delete($image->file_path);
        $image->delete();

        return redirect()->route('admin.media.images.index', $medium->id)
            ->with('success', 'Image deleted successfully!');
    }
}
