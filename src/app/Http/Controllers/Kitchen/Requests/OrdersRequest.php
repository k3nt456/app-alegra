<?php

namespace App\Http\Controllers\Kitchen\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrdersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipes'   => ['required', 'array', 'max:5'],
            'recipes.*' => ['required', 'integer']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Por favor, no modifique la información.');

        throw new HttpResponseException(response()->view('kitchen.kitchen', [], 422));
    }
}
