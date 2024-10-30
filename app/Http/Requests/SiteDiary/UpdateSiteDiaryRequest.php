<?php

namespace App\Http\Requests\SiteDiary;

use App\Models\SiteDiary;
use App\Rules\ProjectBelongsToTenant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteDiaryRequest extends FormRequest
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
            'project_id'  => ['required', 'exists:projects,id', new ProjectBelongsToTenant],
            'name'        => 'string',
            'description' => 'string',

            'staff'              => 'array',
            'staff.*.id'         => 'required_with:staff|exists:users,id',
            'staff.*.entry_time' => 'required_with:staff|date_format:Y-m-d H:i:s',
            'staff.*.exit_time'  => 'required_with:staff|date_format:Y-m-d H:i:s|after:staff.*.entry_time',

            'equipments'   => 'array',
            'equipments.*' =>  'required|in:' . implode(',', SiteDiary::EQUIPMENT),

            'images'   => 'array',
            'images.*' => 'file|max:5000',
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
            'equipments.*.in' => 'Available types are ('.implode(',', SiteDiary::EQUIPMENT).')',
        ];
    }
}
