<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('tipo')
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function toggleEstado(Usuario $usuario)
    {
        $usuario->estado = $usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $usuario->save();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', 'Estado actualizado correctamente.');
    }
}
