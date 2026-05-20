<?php

namespace App\Http\Requests\Tool;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CreateToolRequest extends ApiRequest
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
            'name'  => ['required', 'string','min:3','max:255'],
            'icon' => ['required', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }
}
