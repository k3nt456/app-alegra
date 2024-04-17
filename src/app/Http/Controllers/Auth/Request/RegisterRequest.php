<?php

namespace App\Http\Controllers\Auth\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'max:255'],
            'password'  => ['required', 'string', 'max:255']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('error', 'Hubo errores en los datos enviados, por favor revise los campos.');

        throw new HttpResponseException(response()->view('auth.register', [], 422));
    }
}
