<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteDiary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'description',
        'weather',
    ];

    const EQUIPMENT = [
        'Crane',
        'Excavators',
        'Bulldozers',
        'Loaders',
        'Graders',
        'Paver',
        'Compactors',
        'Forklift',
        'Tractors',
        'Concrete Pump',
        'None'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'weather' => 'json',
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function equipments() : HasMany
    {
        return $this->hasMany(SiteDiaryEquipment::class, 'site_diary_id');
    }

    public function staff() : HasMany
    {
        return $this->hasMany(SiteDiaryStaff::class, 'site_diary_id');
    }

    public function images() : HasMany
    {
        return $this->hasMany(SiteDiaryImage::class, 'site_diary_id');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(SiteDiaryComment::class, 'site_diary_id');
    }

    public function userWatchComments() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'site_diary_watch_comments', 'site_diary_id', 'user_id')->withTimestamps();
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('name', 'like', '%'.$searchWord.'%');
    }

    public function scopeCreatedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
