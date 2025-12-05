<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function ver()
    {
        $usuarios = Usuario::orderBy('tipo')
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();

        return view('admin.usuarios.ver', compact('usuarios'));
    }

    // ===========================================
    // CREAR ADMINISTRADOR
    // ===========================================

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],

            // VALIDACIÓN CÉDULA (9 dígitos, única entre admins)
            'cedula'   => [
                'required',
                'digits:9',
                Rule::unique('usuarios', 'cedula')->where(fn($q) => $q->where('tipo', 'admin')),
            ],

            // ⚠️ CORREO SE MANTIENE EXACTAMENTE COMO LO TENÍAS — NO SE TOCA
            'correo' => ['required', 'email', 'unique:usuarios,correo'],

            // VALIDACIÓN TELÉFONO (8 dígitos, único entre admins)
            'telefono' => [
                'required',
                'digits:8',
                Rule::unique('usuarios', 'telefono')->where(fn($q) => $q->where('tipo', 'admin')),
            ],

            // VALIDACIÓN CONTRASEÑA
            'password' => ['required', 'confirmed', 'min:8'],

        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'nombre.max'        => 'El nombre no puede tener más de 255 caracteres.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max'      => 'El apellido no puede tener más de 255 caracteres.',

            'cedula.required'   => 'La cédula es obligatoria.',
            'cedula.digits'     => 'La cédula debe tener exactamente 9 dígitos.',
            'cedula.unique'     => 'Ya existe un administrador con esta cédula.',

            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'El correo no tiene un formato válido.',
            'correo.unique'     => 'Este correo ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits'   => 'El teléfono debe tener exactamente 8 dígitos.',
            'telefono.unique'   => 'Ya existe un administrador con este teléfono.',

            'password.required'   => 'La contraseña es obligatoria.',
            'password.confirmed'  => 'La confirmación de la contraseña no coincide.',
            'password.min'        => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        Usuario::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'cedula'   => $request->cedula,
            'correo'   => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'tipo'     => 'admin',
            'estado'   => 'activo',
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', 'Administrador creado correctamente.');
    }
}
