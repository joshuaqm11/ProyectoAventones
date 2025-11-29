<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class ChoferReservaController extends Controller
{
    // Reservas pendientes de los rides de este chofer
    public function pendientes()
    {
        $choferId = Auth::id();

        $reservas = Reserva::with(['ride', 'pasajero'])
            ->whereHas('ride', function ($q) use ($choferId) {
                $q->where('usuario_id', $choferId);
            })
            ->where('estado', 'pendiente')
            ->orderByDesc('created_at')
            ->get();

        return view('chofer.reservas_pendientes', compact('reservas'));
    }

    // Todas las reservas (cualquier estado) de los rides de este chofer
    public function todas()
    {
        $choferId = Auth::id();

        $reservas = Reserva::with(['ride', 'pasajero'])
            ->whereHas('ride', function ($q) use ($choferId) {
                $q->where('usuario_id', $choferId);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('chofer.reservas_todas', compact('reservas'));
    }

    // Aceptar una reserva
    public function aceptar(Reserva $reserva)
    {
        $choferId = Auth::id();

        // Seguridad: solo si la reserva pertenece a un ride del chofer
        if ($reserva->ride->usuario_id !== $choferId) {
            abort(403);
        }

        // Solo tiene sentido aceptar si está pendiente
        if ($reserva->estado === 'pendiente') {
            $reserva->update([
                'estado' => 'aceptada',
            ]);
        }

        return back()->with('status', 'Reserva aceptada correctamente.');
    }

    // Rechazar una reserva
    public function rechazar(Reserva $reserva)
    {
        $choferId = Auth::id();

        if ($reserva->ride->usuario_id !== $choferId) {
            abort(403);
        }

        if ($reserva->estado === 'pendiente') {
            $reserva->update([
                'estado' => 'rechazada',
            ]);
        }

        return back()->with('status', 'Reserva rechazada correctamente.');
    }
}
