<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'file_path',
        'date',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

}
