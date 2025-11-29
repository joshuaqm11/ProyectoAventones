<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $table = 'rides';

    // PERMITIMOS la asignación masiva de estos campos
    protected $fillable = [
        'usuario_id',
        'vehiculo_id',
        'origen',
        'destino',
        'fecha',
        'hora',
        'precio',
        'espacios',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
