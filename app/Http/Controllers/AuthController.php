<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================
    //  LOGIN / LOGOUT
    // ==========================

    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login (SIN validar estado)
    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'correo'   => $request->correo,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var \App\Models\Usuario $usuario */
            $usuario = Auth::user();

            // 🔥 Validación de estado desactivada por ahora 🔥
            // if ($usuario->estado !== 'activo') { ... }

            // Redirigir según tipo de usuario
            if ($usuario->tipo === 'chofer') {
                return redirect()->route('chofer.dashboard');
            } elseif ($usuario->tipo === 'pasajero') {
                return redirect()->route('pasajero.dashboard');
            } elseif ($usuario->tipo === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                // Por si existiera algún otro tipo raro
                return redirect()->route('home');
            }
        }

        return back()
            ->withErrors(['correo' => 'Credenciales incorrectas.'])
            ->withInput();
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ==========================
    //  REGISTRO
    // ==========================

    // Formularios de registro
    public function showRegisterChofer()
    {
        return view('auth.register_chofer');
    }

    public function showRegisterPasajero()
    {
        return view('auth.register_pasajero');
    }

    // Guardar chofer
    public function registerChofer(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'cedula'           => 'required|string|max:50|unique:usuarios,cedula',
            'fecha_nacimiento' => 'nullable|date',
            'correo'           => 'required|email|unique:usuarios,correo',
            'telefono'         => 'nullable|string|max:50',
            'password'         => 'required|confirmed|min:4',
        ]);

        $token = Str::random(40);

        $usuario = Usuario::create([
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'cedula'           => $request->cedula,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'correo'           => $request->correo,
            'telefono'         => $request->telefono,
            'password'         => Hash::make($request->password),
            'tipo'             => 'chofer',
            'estado'           => 'pendiente',
            'token_activacion' => $token,
        ]);

        // Mail::to($usuario->correo)->send(new \App\Mail\ActivarCuentaMail($usuario));

        return redirect()->route('login')
            ->with('status', 'Registro exitoso. (Por ahora puedes iniciar sesión sin activar el correo).');
    }

    // Guardar pasajero
    public function registerPasajero(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'cedula'           => 'required|string|max:50|unique:usuarios,cedula',
            'fecha_nacimiento' => 'nullable|date',
            'correo'           => 'required|email|unique:usuarios,correo',
            'telefono'         => 'nullable|string|max:50',
            'password'         => 'required|confirmed|min:4',
        ]);

        $token = Str::random(40);

        $usuario = Usuario::create([
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'cedula'           => $request->cedula,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'correo'           => $request->correo,
            'telefono'         => $request->telefono,
            'password'         => Hash::make($request->password),
            'tipo'             => 'pasajero',
            'estado'           => 'pendiente',
            'token_activacion' => $token,
        ]);

        // Mail::to($usuario->correo)->send(new \App\Mail\ActivarCuentaMail($usuario));

        return redirect()->route('login')
            ->with('status', 'Registro exitoso. (Por ahora puedes iniciar sesión sin activar el correo).');
    }

    // ==========================
    //  ACTIVAR CUENTA
    // ==========================

    public function activarCuenta($token)
    {
        $usuario = Usuario::where('token_activacion', $token)->firstOrFail();

        $usuario->estado = 'activo';
        $usuario->token_activacion = null;
        $usuario->save();

        return redirect()->route('login')
            ->with('status', 'Tu cuenta ha sido activada. Ya puedes iniciar sesión.');
    }
}
