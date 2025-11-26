<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $table = 'rides';

    // Puedes incluso quitar $fillable si quieres,
    // porque en store ya no usamos create().
    protected $fillable = [];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
