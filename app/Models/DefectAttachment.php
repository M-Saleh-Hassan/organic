<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'defect_id',
        'name',
        'url',
    ];
}
