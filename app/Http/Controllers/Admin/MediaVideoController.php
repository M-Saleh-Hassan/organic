<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaVideoController extends Controller
{
    public function index(Media $medium)
    {
        $videos = $medium->videos()->paginate(10);
        return view('admin.media_videos.index', compact('medium', 'videos'));
    }

    public function create(Media $medium)
    {
        return view('admin.media_videos.create', compact('medium'));
    }

    public function store(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'file_path' => 'required|file|mimes:mp4,mkv,avi|max:10240',
            'date' => 'required|date',
        ]);

        $filePath = $request->file('file_path')->store('media/videos', 'public');
        $validated['file_path'] = $filePath;

        $medium->videos()->create($validated);

        return redirect()->route('admin.media.videos.index', $medium)
            ->with('success', 'Video added successfully!');
    }

    public function edit(Media $medium, MediaVideo $video)
    {
        return view('admin.media_videos.edit', compact('video'));
    }

    public function update(Request $request, Media $medium, MediaVideo $video)
    {
        $validated = $request->validate([
            'file_path' => 'nullable|file|mimes:mp4,mkv,avi|max:10240',
            'date' => 'required|date',
        ]);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($video->file_path);
            $filePath = $request->file('file_path')->store('media/videos', 'public');
            $validated['file_path'] = $filePath;
        }

        $video->update($validated);

        return redirect()->route('admin.media.videos.index', $video->media_id)
            ->with('success', 'Video updated successfully!');
    }

    public function destroy(Media $medium, MediaVideo $video)
    {
        Storage::disk('public')->delete($video->file_path);
        $video->delete();

        return redirect()->route('admin.media.videos.index', $medium->id)
            ->with('success', 'Video deleted successfully!');
    }
}
