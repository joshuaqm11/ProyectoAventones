<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Tests\TestCase;

class UsuarioModelTest extends TestCase
{
    public function test_usuario_tiene_campos_basicos_asignables()
    {
        $usuario = new Usuario();

        $usuario->nombre   = 'Juan';
        $usuario->apellido = 'Pérez';
        $usuario->correo   = 'juan@example.com';
        $usuario->tipo     = 'chofer';
        $usuario->estado   = 'pendiente';

        $this->assertSame('Juan', $usuario->nombre);
        $this->assertSame('Pérez', $usuario->apellido);
        $this->assertSame('juan@example.com', $usuario->correo);
        $this->assertSame('chofer', $usuario->tipo);
        $this->assertSame('pendiente', $usuario->estado);
    }
}
