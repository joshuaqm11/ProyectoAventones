<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAdminController extends Controller
{
    public function index()
    {
        $admins = Usuario::where('tipo', 'admin')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula'   => 'required|string|max:50|unique:usuarios,cedula',
            'correo'   => 'required|email|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:50',
            'password' => 'required|confirmed|min:4',
        ]);

        Usuario::create([
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'cedula'           => $request->cedula,
            'fecha_nacimiento' => null,
            'correo'           => $request->correo,
            'telefono'         => $request->telefono,
            'password'         => Hash::make($request->password),
            'tipo'             => 'admin',
            'estado'           => 'activo',
            'token_activacion' => null,
        ]);

        return redirect()
            ->route('admin.admins.index')
            ->with('status', 'Administrador creado correctamente.');
    }
}
