<?php

namespace App\Http\Requests\Defect;

use App\Models\Defect;
use App\Rules\ProjectBelongsToTenant;
use Illuminate\Foundation\Http\FormRequest;

class StoreDefectRequest extends FormRequest
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
            'assignee_id'  => 'required|exists:users,id',
            'title'        => 'required|string',
            'description'  => 'required|string',
            'due_date'     => 'required|date|after:now',

            'work_type' =>  'required|in:' . implode(',', Defect::WORK_TYPES),

            'floor_plan_id' => 'exists:floor_plans,id',
            'attachments'   => 'array',
            'attachments.*' => 'file|max:5000',

            'locations'     => 'array',
            'locations.*.x' => 'required_with:locations|numeric',
            'locations.*.y' => 'required_with:locations|numeric',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'work_type.in' => 'Available types are ('.implode(',', Defect::WORK_TYPES).')',
        ];
    }
}
