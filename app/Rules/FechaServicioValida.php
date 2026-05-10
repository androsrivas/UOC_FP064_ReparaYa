<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FechaServicioValida implements ValidationRule
{
    public function __construct(
        private string $tipoUrgencia, 
        private int $minHours = 48
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $fecha = Carbon::parse($value);
        } catch (\Exception $e) {
            $fail('La fecha proporcionada no es válida.');
            return;
        }

        $horas = now()->diffInHours($fecha, false);

        if ($horas < 0) {
            $fail('La fecha de servicio debe ser futura.');
            return;
        }

        if ($this->tipoUrgencia === 'Estándar' && $horas < $this->minHours) {
            $fail("Las solicitudes estándar requieren un mínimo de {$this->minHours} horas de antelación.");
        }
    }
}
