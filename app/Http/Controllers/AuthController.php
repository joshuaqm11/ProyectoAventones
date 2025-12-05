<?php

namespace App\Http\Controllers;

use App\Mail\ActivarCuentaMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // ==========================
    //  LOGIN / LOGOUT
    // ==========================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()
                ->withErrors(['correo' => 'Credenciales incorrectas.'])
                ->withInput($request->only('correo'));
        }

        if ($usuario->estado === 'pendiente') {
            return back()
                ->withErrors(['correo' => 'Tu cuenta está pendiente de activación. Revisa tu correo electrónico.'])
                ->withInput($request->only('correo'));
        }

        if ($usuario->estado === 'inactivo') {
            return back()
                ->withErrors(['correo' => 'Tu cuenta está inactiva. Contacta al administrador.'])
                ->withInput($request->only('correo'));
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        if ($usuario->tipo === 'chofer') {
            return redirect()->route('chofer.dashboard');
        } elseif ($usuario->tipo === 'pasajero') {
            return redirect()->route('pasajero.dashboard');
        } elseif ($usuario->tipo === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

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
        $fechaMaxima = now()->subYears(18)->toDateString();

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',

            'cedula'           => [
                'required',
                'digits:9',
                Rule::unique('usuarios', 'cedula')->where(fn ($q) => $q->where('tipo', 'chofer')),
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . $fechaMaxima,
            ],

            'correo'           => [
                'required',
                'email',
                'unique:usuarios,correo',
            ],

            'telefono'         => [
                'required',
                'digits:8',
                Rule::unique('usuarios', 'telefono')->where(fn ($q) => $q->where('tipo', 'chofer')),
            ],

            'password'         => [
                'required',
                'confirmed',
                'min:8',
            ],
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

        Mail::to($usuario->correo)->send(new ActivarCuentaMail($usuario));

        return redirect()->route('login')
            ->with('status', 'Registro exitoso. Revisa tu correo para activar la cuenta.');
    }

    // Guardar pasajero
    public function registerPasajero(Request $request)
    {
        $fechaMaxima = now()->subYears(18)->toDateString();

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',

            'cedula'           => [
                'required',
                'digits:9',
                Rule::unique('usuarios', 'cedula')->where(fn ($q) => $q->where('tipo', 'pasajero')),
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . $fechaMaxima,
            ],

            'correo'           => [
                'required',
                'email',
                'unique:usuarios,correo',
            ],

            'telefono'         => [
                'required',
                'digits:8',
                Rule::unique('usuarios', 'telefono')->where(fn ($q) => $q->where('tipo', 'pasajero')),
            ],

            'password'         => [
                'required',
                'confirmed',
                'min:8',
            ],
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

        Mail::to($usuario->correo)->send(new ActivarCuentaMail($usuario));

        return redirect()->route('login')
            ->with('status', 'Registro exitoso. Revisa tu correo para activar la cuenta.');
    }

    // ==========================
    //  ACTIVAR CUENTA
    // ==========================

    public function activarCuenta($token)
    {
        $usuario = Usuario::where('token_activacion', $token)->first();

        if (!$usuario) {
            return redirect()
                ->route('login')
                ->with('status', 'El enlace de activación no es válido o ya fue utilizado.');
        }

        $usuario->estado = 'activo';
        $usuario->token_activacion = null;
        $usuario->save();

        return redirect()->route('login')
            ->with('status', 'Tu cuenta ha sido activada. Ya puedes iniciar sesión.');
    }
}
