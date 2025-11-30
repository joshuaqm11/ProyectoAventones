<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit(Request $request): View
    {
        $usuario = $request->user(); // esto es tu App\Models\Usuario

        return view('profile.edit', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Actualizar información del perfil
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = $request->user();

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'cedula'           => 'required|string|max:50|unique:usuarios,cedula,' . $usuario->id,
            'fecha_nacimiento' => 'nullable|date',
            'correo'           => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'telefono'         => 'nullable|string|max:50',
            'foto'             => 'nullable|image|max:2048',
        ]);

        $usuario->nombre           = $request->nombre;
        $usuario->apellido         = $request->apellido;
        $usuario->cedula           = $request->cedula;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->correo           = $request->correo;
        $usuario->telefono         = $request->telefono;

        // FOTO (opcional)
        if ($request->hasFile('foto')) {
            // borrar foto anterior si existe
            if ($usuario->foto) {
                Storage::disk('public')->delete($usuario->foto);
            }

            $ruta = $request->file('foto')->store('usuarios', 'public');
            $usuario->foto = $ruta;
        }

        $usuario->save();

        // Redirigir según el tipo de usuario
        if ($usuario->tipo === 'chofer') {
            return Redirect::route('chofer.dashboard')
                ->with('status', 'Perfil actualizado correctamente.');
        } elseif ($usuario->tipo === 'pasajero') {
            return Redirect::route('pasajero.dashboard')
                ->with('status', 'Perfil actualizado correctamente.');
        } else {
            return Redirect::route('admin.dashboard')
                ->with('status', 'Perfil actualizado correctamente.');
        }
    }

    /**
     * Eliminar cuenta (si lo usan, si no, lo pueden ignorar)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
