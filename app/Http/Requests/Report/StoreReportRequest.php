<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use App\Rules\ProjectBelongsToTenant;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'project_id'           => ['required', 'exists:projects,id', new ProjectBelongsToTenant],
            'name'                 => 'required|string',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date|after:start_date',
            'report_type'          => 'required|in:' . implode(',', Report::REPORT_TYPES),
            'subcontractors_ids'   => 'required_if:report_type,defect|array',
            'subcontractors_ids.*' => 'required_if:report_type,defect|exists:users,id',
            'floor_plan_id'        => 'required_if:report_type,defect|exists:floor_plans,id',
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
            'report_type.*.in' => 'Available types are (' . implode(',', Report::REPORT_TYPES) . ')',
        ];
    }
}
