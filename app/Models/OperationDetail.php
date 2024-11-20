<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'operation_id',
        'type',
        'description',
        'order',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
