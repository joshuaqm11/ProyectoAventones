<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nombre de la tabla en BD
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'fecha_nacimiento',
        'correo',
        'telefono',
        'foto',
        'password',
        'tipo',
        'estado',
        'token_activacion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

            public function vehiculos()
        {
            return $this->hasMany(Vehiculo::class);
        }

        public function rides()
        {
            return $this->hasMany(Ride::class);
        }

        public function reservas()
        {
            return $this->hasMany(Reserva::class, 'pasajero_id');
        }


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
