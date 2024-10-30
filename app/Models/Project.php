<?php

namespace App\Models;

use App\Services\Weather\WeatherService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'name',
        'description',
        'code',
        'start_date',
        'end_date',
        'company',
        'address',
    ];

    protected static function booted()
    {
        static::addGlobalScope('belongsToAuthenticatedTenant', function (Builder $builder) {
            $builder->whereHas('owner', function (Builder $query) {
                $query->where('users.tenant_id', auth()->user()->tenant_id);
            });
        });

        static::addGlobalScope('onlyAssignedProjectsToCurrentUser', function (Builder $builder) {
            if (auth()->user()->isAdmin()) return ;
            $builder->whereHas('users', function (Builder $query) {
                $query->where('users.id', auth()->user()->id);
            });
        });
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function floorPlans() : HasMany
    {
        return $this->hasMany(FloorPlan::class);
    }

    public function defects() : HasMany
    {
        return $this->hasMany(Defect::class);
    }

    public function siteDiaries() : HasMany
    {
        return $this->hasMany(SiteDiary::class);
    }

    public function reports() : HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('name', 'like', '%'.$searchWord.'%');
    }

    public function scopeBelongsToAuthenticatedTenant($query, $searchWord)
    {
        return $query->where('name', 'like', '%'.$searchWord.'%');
    }

    public static function generateUniqueCode() : string
    {
        $randomString = '';
        do {
            $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 4);
        } while (!empty($randomString) && Project::where('code', $randomString)->exists());

        return $randomString;
    }

    public function getWeatherData()
    {
        if(empty($this->city)) return null;
        return app(WeatherService::class)->getCurrentWeatherByCity($this->city->name);
    }
}
