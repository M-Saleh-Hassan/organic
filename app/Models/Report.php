<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'floor_plan_id',
        'start_date',
        'end_date',
        'name',
        'report_type',
    ];

    const REPORT_TYPES = [
        'diary',
        'defect'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function floorPlan(): BelongsTo
    {
        return $this->belongsTo(FloorPlan::class, 'floor_plan_id');
    }

    public function subcontractors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subcontractor_report', 'report_id', 'subcontractor_id')->withTimestamps();
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('name', 'like', '%' . $searchWord . '%');
    }

    public function getStuffData()
    {
        if ($this->report_type == 'defect') return [];

        return SiteDiaryStaff::whereHas('siteDiary', function ($query) {
            $query->whereBetween('site_diaries.created_at', [$this->start_date, $this->end_date])
                ->whereHas('project', function ($query) {
                    $query->withoutGlobalScopes()->whereHas('owner', function ($query) {
                        $query->where('tenant_id', $this->user->tenant_id);
                    });
                });
        })
            // ->whereBetween('entry_time', [$this->start_date, $this->end_date])
            // ->whereBetween('exit_time', [$this->start_date, $this->end_date])
            ->get();
    }

    public function getSiteDiaries()
    {
        return SiteDiary::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->whereHas('project', function ($query) {
                $query->withoutGlobalScopes()->whereHas('owner', function ($query) {
                    $query->where('tenant_id', $this->user->tenant_id);
                });
            })
            ->get();
    }

    public function getDefects()
    {
        return Defect::withoutGlobalScopes()->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->whereHas('project', function ($query) {
                $query->withoutGlobalScopes()->whereHas('owner', function ($query) {
                    $query->where('tenant_id', $this->user->tenant_id);
                });
            })
            ->get();
    }
}
