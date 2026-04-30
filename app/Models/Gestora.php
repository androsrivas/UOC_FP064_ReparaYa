<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gestora extends Model
{
    protected $table = 'gestoras';
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'procentaje_comision',
        'usuario_id',
        'activa',
    ];

    public function usuario(): BelongsTo {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function comisiones()
    {
        return $this->hasMany(Comision::class, 'empresa_gestora_id');
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'empresa_gestora_id');
    }
}
