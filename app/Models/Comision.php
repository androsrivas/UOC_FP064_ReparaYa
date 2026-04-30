<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comision extends Model
{
    protected $table = 'comisiones';
    protected $fillable = [
        'empresa_gestora_id', 
        'incidencia_id', 
        'importe',
        'precio_base', 
        'porcentaje_aplicado', 
        'mes', 
        'anyo'
    ];

    public function gestora(): BelongsTo
    {
        return $this->belongsTo(Gestora::class, 'empresa_gestora_id');
    }

    public function incidencia(): BelongsTo
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id');
    }
}