<?php

namespace App\Http\Requests;

use App\Models\Tecnico;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTecnicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Tecnico::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // datos usuario
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',

            // datos técnico
            'especialidad_id' => 'required|exists:especialidades,id',
            'telefono' => 'nullable||string|max:20',
        ];
    }

    public function messages(): array 
    {
        return [
            'email.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'especialidad_id.exists' => 'La especialidad seleccionada no es válida.',
        ];
    }
}
