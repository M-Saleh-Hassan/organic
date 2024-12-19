<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            foreach ($media->images as $img) {
                if ($img->file_path) {
                    Storage::delete($img->file_path);
                }
                $img->delete();
            }

            foreach ($media->videos as $video) {
                if ($video->file_path) {
                    Storage::delete($video->file_path);
                }
                $video->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function images()
    {
        return $this->hasMany(MediaImage::class);
    }

    public function videos()
    {
        return $this->hasMany(MediaVideo::class);
    }

}
