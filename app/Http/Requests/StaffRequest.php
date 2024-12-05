<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stafffirstName' => ['required', 'string', 'max:255'],
            'stafflastName' => ['required', 'string', 'max:255'],
            'staffBirthDate' => ['required', 'date'],
            'staffGender' => ['required', 'string', 'max:255'],
            'staffDni' => ['required', 'string', 'max:255'],
            'staffAddress' => ['required', 'string', 'max:255'],
            'staffPhone' => ['required', 'string', 'max:255'],
            'staffPhoto' => ['required', 'string', 'max:255'],
            'userId' => ['required', 'integer']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'stafffirstName.required' => 'El nombre es requerido',
            'stafflastName.required' => 'El apellido es requerido',
            'staffBirthDate.required' => 'La fecha de nacimiento es requerida',
            'staffGender.required' => 'El género es requerido',
            'staffDni.required' => 'El DNI es requerido',
            'staffAddress.required' => 'La dirección es requerida',
            'staffPhone.required' => 'El teléfono es requerido',
            'staffPhoto.required' => 'La foto es requerida',
            'userId.required' => 'El usuario es requerido'
        ];

    }
}
