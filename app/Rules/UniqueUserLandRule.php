<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UniqueUserLandRule implements ValidationRule
{
    protected $table;
    protected $userId;
    protected $landId;

    public function __construct($table, $userId, $landId)
    {
        $this->table = $table;
        $this->userId = $userId;
        $this->landId = $landId;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (Request::isMethod('post')) {
            $exists = DB::table($this->table)
                ->where('user_id', $this->userId)
                ->where('land_id', $this->landId)
                ->exists();

            if ($exists) {
                $fail('The combination of user and land must be unique.');
            }
        }
    }
}
