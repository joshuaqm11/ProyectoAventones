<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $hoy = now()->toDateString();

        // VALIDACIÓN CON REGLAS + POST-VALIDACIÓN DINÁMICA
        $validator = Validator::make($request->all(), [
            'origen'      => ['required', 'string', 'max:255'],
            'destino'     => ['required', 'string', 'max:255'],
            'fecha'       => ['required', 'date', 'after_or_equal:' . $hoy],
            'hora'        => ['required', 'date_format:H:i'],
            'precio'      => ['required', 'numeric', 'min:0'],
            'espacios'    => ['required', 'integer', 'min:1'], // sin max fijo aquí
            'vehiculo_id' => ['required', 'integer', 'exists:vehiculos,id'],
        ], [
            'origen.required'      => 'El origen es obligatorio.',
            'origen.string'        => 'El origen debe ser un texto válido.',
            'origen.max'           => 'El origen no puede tener más de 255 caracteres.',

            'destino.required'     => 'El destino es obligatorio.',
            'destino.string'       => 'El destino debe ser un texto válido.',
            'destino.max'          => 'El destino no puede tener más de 255 caracteres.',

            'fecha.required'       => 'La fecha de salida es obligatoria.',
            'fecha.date'           => 'Ingresa una fecha de salida válida.',
            'fecha.after_or_equal' => 'La fecha de salida no puede ser anterior a hoy.',

            'hora.required'        => 'La hora de salida es obligatoria.',
            'hora.date_format'     => 'La hora de salida debe tener el formato HH:MM (24 horas).',

            'precio.required'      => 'El precio por espacio es obligatorio.',
            'precio.numeric'       => 'El precio por espacio debe ser un número.',
            'precio.min'           => 'El precio por espacio no puede ser negativo.',

            'espacios.required'    => 'Debes indicar la cantidad de espacios disponibles.',
            'espacios.integer'     => 'Los espacios disponibles deben ser un número entero.',
            'espacios.min'         => 'Debe haber al menos 1 espacio disponible.',

            'vehiculo_id.required' => 'Debes seleccionar un vehículo.',
            'vehiculo_id.integer'  => 'El vehículo seleccionado no es válido.',
            'vehiculo_id.exists'   => 'El vehículo seleccionado no existe.',
        ]);

        // Validación dinámica de espacios según capacidad del vehículo
        $validator->after(function ($validator) use ($request) {
            if ($request->vehiculo_id && $request->espacios !== null) {
                $vehiculo = Vehiculo::find($request->vehiculo_id);

                if ($vehiculo) {
                    // capacidad total - 1 (por el chofer)
                    $maxEspacios = max(0, $vehiculo->capacidad - 1);

                    if ($request->espacios > $maxEspacios) {
                        $validator->errors()->add(
                            'espacios',
                            'Los espacios disponibles no pueden ser mayores que la capacidad del vehículo menos el espacio del chofer (máximo ' . $maxEspacios . ').'
                        );
                    }
                }
            }
        });

        $validator->validate();

        // === LÓGICA ORIGINAL (NO TOCADA) ===
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
        $ride->costo        = $request->precio;   // 🔥 forzamos COSTO
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

        $hoy = now()->toDateString();

        $validator = Validator::make($request->all(), [
            'origen'      => ['required', 'string', 'max:255'],
            'destino'     => ['required', 'string', 'max:255'],
            'fecha'       => ['required', 'date', 'after_or_equal:' . $hoy],
            'hora'        => ['required', 'date_format:H:i'],
            'precio'      => ['required', 'numeric', 'min:0'],
            'espacios'    => ['required', 'integer', 'min:1'],
            'vehiculo_id' => ['required', 'integer', 'exists:vehiculos,id'],
            'estado'      => ['nullable', 'string', 'max:50'],
        ], [
            'origen.required'      => 'El origen es obligatorio.',
            'origen.string'        => 'El origen debe ser un texto válido.',
            'origen.max'           => 'El origen no puede tener más de 255 caracteres.',

            'destino.required'     => 'El destino es obligatorio.',
            'destino.string'       => 'El destino debe ser un texto válido.',
            'destino.max'          => 'El destino no puede tener más de 255 caracteres.',

            'fecha.required'       => 'La fecha de salida es obligatoria.',
            'fecha.date'           => 'Ingresa una fecha de salida válida.',
            'fecha.after_or_equal' => 'La fecha de salida no puede ser anterior a hoy.',

            'hora.required'        => 'La hora de salida es obligatoria.',
            'hora.date_format'     => 'La hora de salida debe tener el formato HH:MM (24 horas).',

            'precio.required'      => 'El precio por espacio es obligatorio.',
            'precio.numeric'       => 'El precio por espacio debe ser un número.',
            'precio.min'           => 'El precio por espacio no puede ser negativo.',

            'espacios.required'    => 'Debes indicar la cantidad de espacios disponibles.',
            'espacios.integer'     => 'Los espacios disponibles deben ser un número entero.',
            'espacios.min'         => 'Debe haber al menos 1 espacio disponible.',

            'vehiculo_id.required' => 'Debes seleccionar un vehículo.',
            'vehiculo_id.integer'  => 'El vehículo seleccionado no es válido.',
            'vehiculo_id.exists'   => 'El vehículo seleccionado no existe.',

            'estado.string'        => 'El estado debe ser un texto válido.',
            'estado.max'           => 'El estado no puede tener más de 50 caracteres.',
        ]);

        // Validación dinámica según capacidad del vehículo
        $validator->after(function ($validator) use ($request) {
            if ($request->vehiculo_id && $request->espacios !== null) {
                $vehiculo = Vehiculo::find($request->vehiculo_id);

                if ($vehiculo) {
                    $maxEspacios = max(0, $vehiculo->capacidad - 1);

                    if ($request->espacios > $maxEspacios) {
                        $validator->errors()->add(
                            'espacios',
                            'Los espacios disponibles no pueden ser mayores que la capacidad del vehículo menos el espacio del chofer (máximo ' . $maxEspacios . ').'
                        );
                    }
                }
            }
        });

        $validator->validate();

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
