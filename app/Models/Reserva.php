<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ride;
use App\Models\Usuario;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'ride_id',
        'pasajero_id',
        'estado',
        'cantidad',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function pasajero()
    {
        return $this->belongsTo(Usuario::class, 'pasajero_id');
    }
}
