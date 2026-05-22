<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class ApiRequest extends FormRequest
{
    protected function prepareForValidation(): void{
        $this->merge($this->transformKeys($this->all()));
    }

    protected function failedValidation(Validator $validator){
        $errors = $this->camelCaseArray($validator->errors()->toArray());
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $errors
            ], 422)
        );
    }

    private function transformKeys(array $data): array{
        $transformedData = [];

        foreach($data as $key => $value){
            $newKey = Str::snake($key);
            $transformedData[$newKey] = is_array($value) ? $this->transformKeys($value): $value;
        }

        return $transformedData;
    }

    private function camelCaseArray(array $array): array{
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = Str::camel($key);
            $result[$newKey] = is_array($value) ? $this->camelCaseArray($value): $value;
        }

        return $result;
    }
}
