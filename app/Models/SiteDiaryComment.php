<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteDiaryComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'site_diary_id',
        'mentioned_user_id',
        'comment',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentionedUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'mentioned_user_id');
    }

    public function siteDiary() : BelongsTo
    {
        return $this->belongsTo(SiteDiary::class, 'site_diary_id');
    }
}
