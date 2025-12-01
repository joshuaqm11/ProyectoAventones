<?php

namespace Tests\Feature;

use App\Mail\ActivarCuentaMail;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthRegistroLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registro_chofer_crea_usuario_pendiente_y_envia_correo()
    {
        Mail::fake();

        $response = $this->post(route('registro.chofer.post'), [
            'nombre'                  => 'Juan',
            'apellido'                => 'Pérez',
            'cedula'                  => '123456789',
            'fecha_nacimiento'        => '1990-01-01',
            'correo'                  => 'juan@example.com',
            'telefono'                => '8888-8888',
            'password'                => 'secret123',
            'password_confirmation'   => 'secret123',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('usuarios', [
            'correo' => 'juan@example.com',
            'tipo'   => 'chofer',
            'estado' => 'pendiente',
        ]);

        $usuario = Usuario::where('correo', 'juan@example.com')->first();
        $this->assertNotNull($usuario->token_activacion);

        Mail::assertSent(ActivarCuentaMail::class, function ($mail) use ($usuario) {
            return $mail->usuario->id === $usuario->id;
        });
    }

    /** @test */
    public function usuario_pendiente_no_puede_iniciar_sesion()
    {
        $usuario = Usuario::create([
            'nombre'           => 'Ana',
            'apellido'         => 'López',
            'cedula'           => '987654321',
            'fecha_nacimiento' => '1995-05-05',
            'correo'           => 'ana@example.com',
            'telefono'         => '7777-7777',
            'password'         => Hash::make('clave123'),
            'tipo'             => 'pasajero',
            'estado'           => 'pendiente',
            'token_activacion' => 'token_de_prueba',
        ]);

        $response = $this->post(route('login.post'), [
            'correo'   => 'ana@example.com',
            'password' => 'clave123',
        ]);

        $response
            ->assertSessionHasErrors('correo')
            ->assertSessionDoesntHaveErrors(['password']);

        $this->assertGuest(); // No se inició sesión
    }
}
