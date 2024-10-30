<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProjectBelongsToTenant implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $project = Project::find($value);
        if ($project->owner->tenant_id !== auth()->user()->tenant_id) {
            $fail('The :attribute must belnog to your tenant.');
        }

    }
}
