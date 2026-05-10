<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'telefono',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->nombre;
    }

    // Helpers de rol
    public function isAdmin():bool {
        return $this->rol === 'admin';
    }

    public function isTecnico():bool {
        return $this->rol === 'tecnico';
    }

    public function isGestora():bool {
        return $this->rol === 'gestora';
    }

    public function isParticular():bool {
        return $this->rol === 'particular';
    }

    // Relaciones
    public function tecnico(): HasOne {
        return $this->hasOne(Tecnico::class, 'usuario_id');
    }

    public function gestora():HasOne {
        return $this->hasOne(Gestora::class, 'usuario_id');
    }

    public function incidencias(): HasMany {
        return $this->hasMany(Incidencia::class, 'cliente_id');
    }

}
