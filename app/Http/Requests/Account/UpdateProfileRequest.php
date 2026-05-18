<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'date_of_birth'  => ['required', 'date'],
            'gender'  => ['required', 'in:male,female'],
            'field' => ['required', 'string','min:3', 'max:255'],
            'slogan' => ['required', 'string','min:3', 'max:255'],
            'about_me' => ['required', 'string','min:3'],
            'facebook_link' => ['required', 'url:http,https'],
            'linkedin_link' => ['required', 'url:http,https'],
            'github_link' => ['required', 'url:http,https'],
            'level1' => ['required', 'string','min:3', 'max:255'],
            'level2' => ['required', 'string','min:3', 'max:255'],
            'level3' => ['required', 'string','min:3', 'max:255'],
            'detail' => ['nullable', 'string','min:3', 'max:255'],
        ];
    }
}
