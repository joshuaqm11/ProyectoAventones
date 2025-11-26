<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::where('usuario_id', Auth::id())
            ->with('vehiculo')
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('chofer.rides.index', compact('rides'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::where('usuario_id', Auth::id())->get();

        return view('chofer.rides.create', compact('vehiculos'));
    }

 public function store(Request $request)
{
    $request->validate([
        'origen'      => 'required|string|max:255',
        'destino'     => 'required|string|max:255',
        'fecha'       => 'required|date',
        'hora'        => 'required',
        'precio'      => 'required|numeric|min:0',
        'espacios'    => 'required|integer|min:1',
        'vehiculo_id' => 'required|exists:vehiculos,id',
    ]);

    $ride = new Ride();

    $ride->usuario_id   = Auth::id();
    $ride->vehiculo_id  = $request->vehiculo_id;

    $ride->nombre       = 'Ride de ' . auth()->user()->nombre;

    // nuestros campos
    $ride->origen       = $request->origen;
    $ride->destino      = $request->destino;
    $ride->fecha        = $request->fecha;
    $ride->hora         = $request->hora;

    // columnas existentes en la BD
    $ride->lugar_salida  = $request->origen;
    $ride->lugar_llegada = $request->destino;

    $ride->precio       = $request->precio;
    $ride->costo        = $request->precio;   // 🔥 AQUÍ forzamos COSTO
    $ride->espacios     = $request->espacios;
    $ride->estado       = 'activo';

    $ride->save();

    return redirect()
        ->route('chofer.rides.index')
        ->with('status', 'Ride creado correctamente.');
}
    public function edit(Ride $ride)
    {
        // asegurar que el ride sea del chofer logueado
        if ($ride->usuario_id !== Auth::id()) {
            abort(403);
        }

        $vehiculos = Vehiculo::where('usuario_id', Auth::id())->get();

        return view('chofer.rides.edit', compact('ride', 'vehiculos'));
    }

    public function update(Request $request, Ride $ride)
    {
        if ($ride->usuario_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'origen'      => 'required|string|max:255',
            'destino'     => 'required|string|max:255',
            'fecha'       => 'required|date',
            'hora'        => 'required',
            'precio'      => 'required|numeric|min:0',
            'espacios'    => 'required|integer|min:1',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'estado'      => 'nullable|string|max:50',
        ]);

        $ride->update([
            'vehiculo_id' => $request->vehiculo_id,
            'origen'      => $request->origen,
            'destino'     => $request->destino,
            'fecha'       => $request->fecha,
            'hora'        => $request->hora,
            'precio'      => $request->precio,
            'espacios'    => $request->espacios,
            'estado'      => $request->estado ?? $ride->estado,
        ]);

        return redirect()
            ->route('chofer.rides.index')
            ->with('status', 'Ride actualizado correctamente.');
    }

    public function destroy(Ride $ride)
    {
        if ($ride->usuario_id !== Auth::id()) {
            abort(403);
        }

        $ride->delete();

        return redirect()
            ->route('chofer.rides.index')
            ->with('status', 'Ride eliminado correctamente.');
    }
}
