<?php

namespace Tests\Unit;

use App\Models\Ride;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class RideModelTest extends TestCase
{
    public function test_ride_tiene_atributos_basicos_asignables()
    {
        $ride = new Ride();

        $ride->origen   = 'San José';
        $ride->destino  = 'Alajuela';
        $ride->precio   = 2500;
        $ride->espacios = 3;

        $this->assertSame('San José', $ride->origen);
        $this->assertSame('Alajuela', $ride->destino);
        $this->assertSame(2500, $ride->precio);
        $this->assertSame(3, $ride->espacios);
    }

    public function test_ride_pertenece_a_un_usuario()
    {
        $ride = new Ride();

        $this->assertInstanceOf(BelongsTo::class, $ride->usuario());
    }

    public function test_ride_pertenece_a_un_vehiculo()
    {
        $ride = new Ride();

        $this->assertInstanceOf(BelongsTo::class, $ride->vehiculo());
    }
}
