<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaImage extends Model
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

        static::deleting(function ($image) {
            if ($image->file_path) {
                Storage::delete($image->file_path);
            }
        });
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

}
