<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_id',
        'file_path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($financial) {
            if ($financial->file_path) {
                Storage::delete($financial->file_path);
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

    public function records()
    {
        return $this->hasMany(FinancialRecord::class);
    }
}
