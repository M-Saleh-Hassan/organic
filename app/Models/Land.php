<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Land extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_number',
        'size',
        'number_of_pits',
        'number_of_palms',
        'cultivation_year',
        'missing_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
