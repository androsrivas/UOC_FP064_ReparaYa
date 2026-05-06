<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class FechaServicioValida implements ValidationRule
{
    public function __construct(private int $hours = 48) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fecha = Carbon::parse($value);
        $horas = now()->diffInHours($fecha, false);

        if ($horas < 0) {
            $fail('La fecha de servicio debe ser futura.');
            return;
        }

        if ($this->tipoUrgencia === 'Estándar' && $horas < 48) {
            $fail('Las solicitudes estándard requieren un mínimo de 48 horas de antelación.');
        }
    }
}
