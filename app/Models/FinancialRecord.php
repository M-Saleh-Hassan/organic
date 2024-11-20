<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_id',
        'month',
        'date', // Full date for the record
        'amount',
    ];

    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }

}
