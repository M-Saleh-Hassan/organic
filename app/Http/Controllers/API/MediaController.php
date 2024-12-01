<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $media = Media::with(['user', 'land', 'images', 'videos'])
            ->where('user_id', auth()->id())
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(MediaResource::collection($media));
    }

    public function show(Media $media)
    {
        $media->load(['user', 'land', 'images', 'videos']);
        return $this->handleResponse(new MediaResource($media));
    }
}
