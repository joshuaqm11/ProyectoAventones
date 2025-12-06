<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasajeroReservaController extends Controller
{
    // 1) Buscar rides disponibles (vista del pasajero)
    public function buscarRides(Request $request)
    {
        $query = Ride::query();

        // Filtros opcionales
        if ($request->filled('origen')) {
            $query->where('origen', 'like', '%' . $request->origen . '%');
        }

        if ($request->filled('destino')) {
            $query->where('destino', 'like', '%' . $request->destino . '%');
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $rides = $query
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('pasajero.rides_disponibles', compact('rides'));
    }

    // 2) Reservar un ride
    public function reservar(Request $request, Ride $ride)
    {
        $pasajeroId = Auth::id();

        $data = $request->validate([
            'cantidad' => 'required|integer|min:1|max:' . $ride->espacios,
        ]);

        // Evitar reserva duplicada para el mismo ride
        $existe = Reserva::where('pasajero_id', $pasajeroId)
            ->where('ride_id', $ride->id)
            ->exists();

        if ($existe) {
            return back()->with('status', 'Ya tienes una reserva para este ride.');
        }

        Reserva::create([
            'ride_id'     => $ride->id,
            'pasajero_id' => $pasajeroId,
            'cantidad'    => $data['cantidad'],
            'estado'      => 'pendiente',
        ]);

        return back()->with('status', 'Reserva registrada correctamente.');
    }

    // 3) Reservas ACTIVAS (pendientes / aceptadas y con rides de hoy o futuros)
    public function reservasActivas()
    {
        $hoy = now()->toDateString();

        $reservas = Reserva::with('ride')
            ->where('pasajero_id', Auth::id())
            ->whereIn('estado', ['pendiente', 'aceptada'])
            ->whereHas('ride', function ($q) use ($hoy) {
                $q->whereDate('fecha', '>=', $hoy);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('pasajero.reservas_activas', compact('reservas'));
    }

    // 4) HISTORIAL (rides pasados o reservas canceladas / rechazadas / finalizadas)
    public function reservasHistorial()
    {
        $hoy = now()->toDateString();

        $reservas = Reserva::with('ride')
            ->where('pasajero_id', Auth::id())
            ->where(function ($q) use ($hoy) {
                $q->whereHas('ride', function ($sub) use ($hoy) {
                    // rides cuya fecha ya pasó
                    $sub->whereDate('fecha', '<', $hoy);
                })
                ->orWhereIn('estado', ['cancelada', 'rechazada', 'finalizada']);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('pasajero.reservas_historial', compact('reservas'));
    }

    // 5) Cancelar reserva
    public function cancelar(Reserva $reserva)
    {
        if ($reserva->pasajero_id !== Auth::id()) {
            abort(403);
        }

        $reserva->update([
            'estado' => 'cancelada',
        ]);

        return back()->with('status', 'Reserva cancelada.');
    }

    // 6) Listado público de rides (landing / página pública)
    public function publicos(Request $request)
    {
        $query = Ride::query();

        // Filtros por origen y destino
        if ($request->filled('origen')) {
            $query->where('origen', 'like', '%' . $request->origen . '%');
        }

        if ($request->filled('destino')) {
            $query->where('destino', 'like', '%' . $request->destino . '%');
        }

        // Orden
        $orden = $request->get('orden', 'fecha'); // campo por defecto
        $dir   = $request->get('dir', 'asc');     // dirección por defecto

        switch ($orden) {
            case 'origen':
                $query->orderBy('origen', $dir)
                      ->orderBy('fecha')
                      ->orderBy('hora');
                break;

            case 'destino':
                $query->orderBy('destino', $dir)
                      ->orderBy('fecha')
                      ->orderBy('hora');
                break;

            case 'fecha':
            default:
                $query->orderBy('fecha', $dir)
                      ->orderBy('hora');
                break;
        }

        $rides = $query->get();

        return view('public.rides_publicos', [
            'rides'       => $rides,
            'ordenActual' => $orden,
            'dirActual'   => $dir,
        ]);
    }
}
