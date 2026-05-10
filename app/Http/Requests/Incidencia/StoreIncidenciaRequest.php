<?php

namespace App\Http\Requests\Incidencia;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Incidencia;
use Illuminate\Support\Facades\Gate;
use App\Rules\FechaServicioValida;

class StoreIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::authorize('create', Incidencia::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'especialidad_id' => 'required|exists:especialidades,id',
            'zona_id' => 'required|exists:zonas,id',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:255',
            'poblacion' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'fecha_servicio' => ['required', 'date', new FechaServicioValida($this->input('tipo_urgencia'))],
            'tipo_urgencia' => 'required|in:Estándar,Urgente',
            'precio_base' => 'required|numeric|min:0',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'especialidad_id.required' => 'La especialidad es obligatoria.',
            'especialidad_id.exists' => 'La especialidad seleccionada no es válida.',
            'zona_id.required' => 'La zona es obligatoria.',
            'zona_id.exists' => 'La zona seleccionada no es válida.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede exceder los 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',
            'poblacion.required' => 'La población es obligatoria.',
            'poblacion.string' => 'La población debe ser una cadena de texto.',
            'poblacion.max' => 'La población no puede exceder los 100 caracteres.',
            'codigo_postal.required' => 'El código postal es obligatorio.',
            'codigo_postal.string' => 'El código postal debe ser una cadena de texto.',
            'codigo_postal.max' => 'El código postal no puede exceder los 5 caracteres.',
            'fecha_servicio.required' => 'La fecha del servicio es obligatoria.',
            'fecha_servicio.date' => 'La fecha del servicio debe ser una fecha válida.',
            'tipo_urgencia.required' => 'El tipo de urgencia es obligatorio.',
            'tipo_urgencia.in' => 'El tipo de urgencia seleccionado no es válido. Debe ser "Estándar" o "Urgente".',
            'precio_base.required' => 'El precio base es obligatorio.',
            'precio_base.numeric' => 'El precio base debe ser un número válido.',
            'precio_base.min' => 'El precio base no puede ser negativo.',
        ];
    }
}
