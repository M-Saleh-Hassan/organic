<?php

namespace App\Http\Requests\FloorPlan;

use Illuminate\Foundation\Http\FormRequest;

class StoreFloorPlanVersionRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'floor_plan_id' => $this->floorPlan->id
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
            'name' => 'required',
            'file' => 'required|file|mimetypes:application/pdf|max:5000',
        ];
    }
}
