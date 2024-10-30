<?php

namespace App\Rules;

use App\Models\SiteDiary;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SiteDiaryBelongsToTenant implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $siteDiary = SiteDiary::find($value);
        if ($siteDiary->project->owner->tenant_id !== auth()->user()->tenant_id) {
            $fail('The :attribute must belnog to your tenant.');
        }

    }
}
