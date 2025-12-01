<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\Ride;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RideCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function chofer_autenticado_puede_crear_un_ride()
    {
        // Crear un chofer activo
        $chofer = Usuario::create([
            'nombre'           => 'Carlos',
            'apellido'         => 'Ramírez',
            'cedula'           => '111222333',
            'fecha_nacimiento' => '1988-02-10',
            'correo'           => 'carlos@example.com',
            'telefono'         => '8888-0000',
            'password'         => Hash::make('password123'),
            'tipo'             => 'chofer',
            'estado'           => 'activo',
            'token_activacion' => null,
        ]);

        // Vehículo del chofer
        $vehiculo = Vehiculo::create([
            'usuario_id' => $chofer->id,
            'placa'      => 'ABC123',
            'marca'      => 'Toyota',
            'modelo'     => 'Yaris',
            'anio'       => 2020,
            'color'      => 'Rojo',
            'fotografia' => null,
            'capacidad'  => 4,
        ]);

        // Autenticar como ese chofer
        $this->actingAs($chofer);

        $response = $this->post(route('chofer.rides.store'), [
            'vehiculo_id' => $vehiculo->id,
            'origen'      => 'San José',
            'destino'     => 'Heredia',
            'fecha'       => '2025-01-01',
            'hora'        => '08:00',
            'precio'      => 1500,
            'espacios'    => 3,
        ]);

        $response->assertRedirect(route('chofer.rides.index'));

        $this->assertDatabaseHas('rides', [
            'usuario_id'  => $chofer->id,
            'vehiculo_id' => $vehiculo->id,
            'origen'      => 'San José',
            'destino'     => 'Heredia',
        ]);
    }
}
