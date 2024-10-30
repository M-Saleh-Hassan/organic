<?php

namespace App\Http\Requests\Project;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
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
            'name'        => 'required|string',
            'description' => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'company'     => 'required|string',
            'address'     => 'required|string',
            'city_id'     => 'exists:cities,id',

            'users'   => 'array',
            'users.*' => 'exists:users,id',

            'floor_plans'        => 'array',
            'floor_plans.*.name' => 'required_with:floor_plans',
            'floor_plans.*.file' => 'required_with:floor_plans|file|mimetypes:application/pdf|max:5000',

        ];
    }
}
