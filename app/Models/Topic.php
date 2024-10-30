<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeSearch($query, $searchWord)
    {
        if (empty($searchWord)) return;
        return $query->where('name', 'like', '%' . $searchWord . '%')
            ->orWhere('description', 'like', '%' . $searchWord . '%')
            ->orWhereHas('questions', function (Builder $query) use ($searchWord) {
                $query->search($searchWord);
            });
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
