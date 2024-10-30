<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public const PERMISSIONS = [
        'dashboard'    => 'dashboard',
        'projects'     => 'projects',
        'defects'      => 'defects',
        'floor_plans'  => 'floor_plans',
        'site_diaries' => 'site_diaries',
        'reports'      => 'reports',
        'users'        => 'users',
    ];
}
