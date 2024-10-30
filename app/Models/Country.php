<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function scopeSearch($query, $searchWord)
    {
        return $query->where('name', 'like', '%'.$searchWord.'%');
    }
}
