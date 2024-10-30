<?php

namespace App\Http\Requests\SiteDiary;

use App\Models\SiteDiary;
use App\Rules\ProjectBelongsToTenant;
use App\Rules\SiteDiaryBelongsToTenant;
use Illuminate\Foundation\Http\FormRequest;

class StoreSiteDiaryCommentRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'site_diary_id' => $this->siteDiary->id
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
            'site_diary_id'     => ['required', 'exists:site_diaries,id', new SiteDiaryBelongsToTenant],
            'comment'           => 'required|string',
            'mentioned_user_id' => 'exists:users,id',
        ];
    }

}
