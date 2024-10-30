<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\UserCreatedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'company',
        'position',
        'image',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getProfileImageAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('avatar.svg');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function userProjects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function hasPermission($permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('first_name', 'like', '%' . $searchWord . '%')->orWhere('last_name', 'like', '%' . $searchWord . '%');
    }

    public function scopeFilterByType($query, $userType)
    {
        if (empty($userType)) return;

        return $query->whereHas(
            'role',
            fn(Builder $query) =>
            $query->where('roles.id', $userType)
        );
    }

    public function scopeFilterByProject($query, $projectId)
    {
        if (empty($projectId)) return;

        return $query->whereHas(
            'projects',
            fn(Builder $query) =>
            $query->where('projects.id', $projectId)
        );
    }

    public function scopeNotAdmin($query)
    {
        return $query->whereHas(
            'role',
            fn(Builder $query) =>
            $query->where('roles.name', '!=', 'admin')
        );
    }

    public function scopeBelongsToAuthenticatedTenant($query)
    {
        return $query->where('users.tenant_id', auth()->user()->tenant_id);
    }

    public function siteDiaryWatchComments(): BelongsToMany
    {
        return $this->belongsToMany(SiteDiary::class, 'site_diary_watch_comments', 'user_id', 'site_diary_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function notifyUserForPasswordCreation()
    {
        $token = Password::createToken($this);
        $this->notify(new UserCreatedNotification($token));
    }


    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->device_token;
    }

    public function isAdmin()
    {
        return $this->role->name == 'admin';
    }

}
