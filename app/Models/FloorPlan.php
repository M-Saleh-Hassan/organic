<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FloorPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'floor_plan_id',
        'name',
        'url',
    ];

    public function floorPlans(): HasMany
    {
        return $this->hasMany(FloorPlan::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('name', 'like', '%' . $searchWord . '%');
    }

    public function scopeIncludingMainParent($query, $parentId)
    {
        return $query->orWhere('id', $parentId);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('floor_plan_id');
    }
}
