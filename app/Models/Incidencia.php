<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incidencia extends Model
{
    protected $table = 'incidencias';
    protected $fillable = [
        'localizador',
        'cliente_id',
        'tecnico_id',
        'especialidad_id',
        'zona_id',
        'titulo',
        'descripcion',
        'direccion',
        'poblacion',
        'codigo_postal',
        'fecha_servicio',
        'tipo_urgencia',
        'estado',
        'cancel_at',
        'cancel_by',
        'precio_base',
        'gstora_id',
    ];

    protected $casts = [
        'fecha_servicio' => 'datetime',
        'cancel_at' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class, 'tecnico_id');
    }

    public function especialidad(): BelongsTo
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function comision(): HasOne
    {
        return $this->hasOne(Comision::class, 'incidencia_id');
    }

    public function gestora(): BelongsTo
    {
        return $this->belongsTo(Gestora::class, 'gestora_id');
    }
}
