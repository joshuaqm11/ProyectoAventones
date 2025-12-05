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
        $anioMaximo = now()->year + 1;

        $request->validate([
            'placa'     => ['required','string','max:10','regex:/^[A-Z0-9]+$/i','unique:vehiculos,placa'],
            'marca'     => ['required','string','max:100'],
            'modelo'    => ['required','string','max:100'],
            'anio'      => ['required','integer','digits:4','between:1990,' . $anioMaximo],
            'color'     => ['required','string','max:50'],
            'capacidad' => ['required','integer','min:1','max:8'],
            'fotografia'=> ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ], [
            'placa.required'  => 'La placa es obligatoria.',
            'placa.max'       => 'La placa no puede tener más de 10 caracteres.',
            'placa.regex'     => 'La placa solo puede contener letras y números, sin guiones ni espacios.',
            'placa.unique'    => 'Esta placa ya está registrada.',

            'marca.required'  => 'La marca es obligatoria.',
            'marca.max'       => 'La marca no puede tener más de 100 caracteres.',

            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.max'      => 'El modelo no puede tener más de 100 caracteres.',

            'anio.required'   => 'El año es obligatorio.',
            'anio.integer'    => 'El año debe ser un número.',
            'anio.digits'     => 'El año debe tener 4 dígitos.',
            'anio.between'    => 'El año debe estar entre 1990 y ' . $anioMaximo . '.',

            'color.required'  => 'El color es obligatorio.',
            'color.max'       => 'El color no puede tener más de 50 caracteres.',

            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer'  => 'La capacidad debe ser un número entero.',
            'capacidad.min'      => 'La capacidad mínima es 1.',
            'capacidad.max'      => 'La capacidad máxima permitida es 8.',

            'fotografia.image' => 'La fotografía debe ser una imagen válida.',
            'fotografia.mimes' => 'La fotografía debe ser JPG o PNG.',
            'fotografia.max'   => 'La fotografía no puede superar 2 MB.',
        ]);

        $rutaFoto = null;

        if ($request->hasFile('fotografia')) {
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

        $anioMaximo = now()->year + 1;

        $request->validate([
            'placa'     => ['required','string','max:10','regex:/^[A-Z0-9]+$/i','unique:vehiculos,placa,' . $vehiculo->id],
            'marca'     => ['required','string','max:100'],
            'modelo'    => ['required','string','max:100'],
            'anio'      => ['required','integer','digits:4','between:1990,' . $anioMaximo],
            'color'     => ['required','string','max:50'],
            'capacidad' => ['required','integer','min:1','max:8'],
            'fotografia'=> ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ], [
            'placa.required'  => 'La placa es obligatoria.',
            'placa.max'       => 'La placa no puede tener más de 10 caracteres.',
            'placa.regex'     => 'La placa solo puede contener letras y números, sin guiones ni espacios.',
            'placa.unique'    => 'Esta placa ya está registrada.',

            'marca.required'  => 'La marca es obligatoria.',
            'marca.max'       => 'La marca no puede tener más de 100 caracteres.',

            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.max'      => 'El modelo no puede tener más de 100 caracteres.',

            'anio.required'   => 'El año es obligatorio.',
            'anio.integer'    => 'El año debe ser un número.',
            'anio.digits'     => 'El año debe tener 4 dígitos.',
            'anio.between'    => 'El año debe estar entre 1990 y ' . $anioMaximo . '.',

            'color.required'  => 'El color es obligatorio.',
            'color.max'       => 'El color no puede tener más de 50 caracteres.',

            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer'  => 'La capacidad debe ser un número entero.',
            'capacidad.min'      => 'La capacidad mínima es 1.',
            'capacidad.max'      => 'La capacidad máxima permitida es 8.',

            'fotografia.image' => 'La fotografía debe ser una imagen válida.',
            'fotografia.mimes' => 'La fotografía debe ser JPG o PNG.',
            'fotografia.max'   => 'La fotografía no puede superar 2 MB.',
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
