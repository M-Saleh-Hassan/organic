<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'file_path',
        'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($video) {
            if ($video->file_path) {
                Storage::delete($video->file_path);
            }
        });
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

}
