<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::where('usuario_id', Auth::id())->get();

        return view('chofer.vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('chofer.vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa'     => 'required|string|max:50',
            'marca'     => 'required|string|max:100',
            'modelo'    => 'required|string|max:100',
            'anio'      => 'required|integer',
            'color'     => 'required|string|max:50',
            'capacidad' => 'required|integer|min:1',
            'fotografia'=> 'nullable|image|max:2048', // jpg, png, etc.
        ]);

        $rutaFoto = null;

        if ($request->hasFile('fotografia')) {
            // se guarda en storage/app/public/vehiculos
            $rutaFoto = $request->file('fotografia')
                                ->store('vehiculos', 'public');
        }

        Vehiculo::create([
            'usuario_id' => Auth::id(),
            'placa'      => $request->placa,
            'marca'      => $request->marca,
            'modelo'     => $request->modelo,
            'anio'       => $request->anio,
            'color'      => $request->color,
            'capacidad'  => $request->capacidad,
            'fotografia' => $rutaFoto,
        ]);

        return redirect()
            ->route('chofer.vehiculos.index')
            ->with('status', 'Vehículo registrado correctamente.');
    }

    public function edit(Vehiculo $vehiculo)
    {
        if ($vehiculo->usuario_id !== Auth::id()) {
            abort(403);
        }

        return view('chofer.vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        if ($vehiculo->usuario_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'placa'     => 'required|string|max:50',
            'marca'     => 'required|string|max:100',
            'modelo'    => 'required|string|max:100',
            'anio'      => 'required|integer',
            'color'     => 'required|string|max:50',
            'capacidad' => 'required|integer|min:1',
            'fotografia'=> 'nullable|image|max:2048',
        ]);

        $data = [
            'placa'     => $request->placa,
            'marca'     => $request->marca,
            'modelo'    => $request->modelo,
            'anio'      => $request->anio,
            'color'     => $request->color,
            'capacidad' => $request->capacidad,
        ];

        if ($request->hasFile('fotografia')) {
            // borrar foto anterior si existía
            if ($vehiculo->fotografia) {
                Storage::disk('public')->delete($vehiculo->fotografia);
            }

            $data['fotografia'] = $request->file('fotografia')
                                          ->store('vehiculos', 'public');
        }

        $vehiculo->update($data);

        return redirect()
            ->route('chofer.vehiculos.index')
            ->with('status', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        if ($vehiculo->usuario_id !== Auth::id()) {
            abort(403);
        }

        if ($vehiculo->fotografia) {
            Storage::disk('public')->delete($vehiculo->fotografia);
        }

        $vehiculo->delete();

        return redirect()
            ->route('chofer.vehiculos.index')
            ->with('status', 'Vehículo eliminado correctamente.');
    }
}
