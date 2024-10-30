<?php

namespace App\Http\Requests\FloorPlan;

use App\Rules\ProjectBelongsToTenant;
use Illuminate\Foundation\Http\FormRequest;

class IndexFloorPlanRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'project_id' => $this->project->id
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id'   => ['required', 'exists:projects,id', new ProjectBelongsToTenant],
        ];
    }

}
