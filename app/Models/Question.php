<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'answer',
    ];

    public function scopeSearch($query, $searchWord)
    {
        if (empty($searchWord)) return;
        return $query->where('title', 'like', '%' . $searchWord . '%')
            ->orWhere('answer', 'like', '%' . $searchWord . '%');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
