<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ApiRequest extends FormRequest
{
    protected function prepareForValidation(): void{
        $this->merge($this->transformKeys($this->all()));
    }

    private function transformKeys(array $data): array{
        $transformedData = [];

        foreach($data as $key => $value){
            $newKey = Str::snake($key);
            $transformedData[$newKey] = is_array($value) ? $this->transformKeys($value): $value;
        }

        return $transformedData;
    }

}
