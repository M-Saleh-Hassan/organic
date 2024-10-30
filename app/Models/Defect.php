<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Defect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'assignee_id',
        'floor_plan_id',
        'title',
        'work_type',
        'due_date',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    const WORK_TYPES = [
        'Plumbing',
        'Electrical',
        'Cleaning',
        'Carpentry',
        'Masonry',
        'Roofing',
        'Painting',
        'Plastering',
        'Caulking',
        'Flooring',
        'HVAC',
        'Landscaping',
        'Gardening',
        'Miscellaneous',
        'Insulating',
        'Windows',
        'Lighting',
        'Inspection',
        'Concrete',
        'Framing',
        'Other'
    ];

    const STATUS = [
        'Open',
        'In Progress',
        'Closed',
    ];

    protected static function booted()
    {
        static::addGlobalScope('belongsToAuthenticatedTenant', function (Builder $builder) {
            $builder->whereHas('user', function (Builder $query) {
                $query->where('users.tenant_id', auth()->user()->tenant_id);
            });
        });
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function floorPlan() : BelongsTo
    {
        return $this->belongsTo(FloorPlan::class, 'floor_plan_id');
    }

    public function assignee() : BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function attachments() : HasMany
    {
        return $this->hasMany(DefectAttachment::class);
    }

    public function locations() : HasMany
    {
        return $this->hasMany(DefectLocation::class);
    }

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('title', 'like', '%'.$searchWord.'%');
    }

    public function scopeStatus($query, $status)
    {
        if(empty($status)) return;
        return $query->where('status', $status);
    }

    public function scopeNotStatus($query, $status)
    {
        return $query->where('status', '<>', $status);
    }

    public function scopeCreatedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeForAssignee($query, $assigneeId)
    {
        if(empty($assigneeId)) return;
        return $query->where('assignee_id', $assigneeId);
    }
}
