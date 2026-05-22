<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CreateProductRequest extends ApiRequest
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
            'links' => ['required','array','min:1'],
            'links.*.title' => ['required', 'string','min:3','max:255'],
            'links.*.url' => ['required', 'url'],
            'techs'  => ['required','array','min:1'],
            'techs.*.tech_id' =>['required', 'exists:techs,id']
        ];
    }
}
