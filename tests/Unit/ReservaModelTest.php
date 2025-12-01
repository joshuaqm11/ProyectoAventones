<?php

namespace Tests\Unit;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ReservaModelTest extends TestCase
{
    public function test_reserva_pertenece_a_un_ride()
    {
        $reserva = new Reserva();

        $this->assertInstanceOf(BelongsTo::class, $reserva->ride());
    }

    public function test_reserva_pertenece_a_un_pasajero()
    {
        $reserva = new Reserva();

        $this->assertInstanceOf(BelongsTo::class, $reserva->pasajero());
    }

    public function test_reserva_tiene_atributos_basicos_asignables()
    {
        $reserva = new Reserva();

        $reserva->cantidad = 2;
        $reserva->estado   = 'pendiente';

        $this->assertSame(2, $reserva->cantidad);
        $this->assertSame('pendiente', $reserva->estado);
    }
}
