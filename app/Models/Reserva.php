<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id','pasajero_id','estado','cantidad',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function pasajero()
    {
        return $this->belongsTo(Usuario::class, 'pasajero_id');
    }
}

