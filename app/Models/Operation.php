<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

    public function details()
    {
        return $this->hasMany(OperationDetail::class)->orderBy('order', 'asc');
    }
}
