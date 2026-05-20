<?php

namespace App\Http\Requests\Education;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CreateEducationRequest extends ApiRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'degree' => ['required', 'string', 'min:3', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
