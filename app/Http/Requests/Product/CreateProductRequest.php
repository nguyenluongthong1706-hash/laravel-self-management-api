<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'description'  => ['required', 'string','min:3','max:255'],
            'task'  => ['required', 'string','min:3','max:255'],
            'image' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
            'start_date'  => ['required', 'date'],
            'end_date'  => ['required', 'date'],
            'urls' => ['required','array','min:1'],
            'url.*.title' => ['required', 'string','min:3','max:255'],
            'url.*.link' => ['required', 'url:http,https'],
            'techs'  => ['required','array','min:1'],
            'tech.*.tech_id' =>['required', 'exists:techs,id']
        ];
    }
}
