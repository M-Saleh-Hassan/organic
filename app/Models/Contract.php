<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_id',
        'sponsorship_contract_path',
        'participation_contract_path',
        'personal_id_path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($contract) {
            if ($contract->sponsorship_contract_path) {
                Storage::delete($contract->sponsorship_contract_path);
            }
            if ($contract->participation_contract_path) {
                Storage::delete($contract->participation_contract_path);
            }
            if ($contract->personal_id_path) {
                Storage::delete($contract->personal_id_path);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

}
