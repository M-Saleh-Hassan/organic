<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

}
