<?php

namespace App\Http\Controllers\Kitchen\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RamdomOrdersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'count' => ['required', 'integer', 'between:1,5']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Por favor, rellene el campo de cantidad correctamente.');

        throw new HttpResponseException(response()->view('kitchen.kitchen', [], 422));
    }
}
