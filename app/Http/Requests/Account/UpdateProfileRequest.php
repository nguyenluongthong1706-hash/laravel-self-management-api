<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class UpdateProfileRequest extends ApiRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:3', 'max:255'],
            'date_of_birth'  => ['required', 'date', 'before_or_equal:today'],
            'gender'  => ['required', 'in:male,female'],
            'field' => ['required', 'string','min:3', 'max:255'],
            'slogan' => ['required', 'string','min:3', 'max:255'],
            'about_me' => ['required', 'string','min:3'],
            'facebook_link' => ['required', 'url'],
            'linkedin_link' => ['required', 'url'],
            'github_link' => ['required', 'url'],
            'location' => ['required', 'array'],
            'location.province' => ['required', 'string','min:3', 'max:255'],
            'location.district' => ['required', 'string','min:3', 'max:255'],
            'location.ward' => ['required', 'string','min:3', 'max:255'],
            'location.detail' => ['nullable', 'string','min:3', 'max:255'],
        ];
    }
}
