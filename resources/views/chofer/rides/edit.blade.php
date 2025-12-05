@extends('layouts.app')

@section('title', 'Editar ride')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Editar ride</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('chofer.rides.update', $ride) }}">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label class="form-label">Origen</label>
            <input type="text" name="origen" class="form-control" value="{{ old('origen', $ride->origen) }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Destino</label>
            <input type="text" name="destino" class="form-control" value="{{ old('destino', $ride->destino) }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Fecha de salida</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $ride->fecha) }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Hora de salida</label>
            <input type="time" name="hora" class="form-control" value="{{ old('hora', $ride->hora) }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Precio por espacio</label>
            <input type="number" name="precio" class="form-control" value="{{ old('precio', $ride->precio) }}" min="0" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Espacios disponibles</label>
            <input type="number" name="espacios" class="form-control" value="{{ old('espacios', $ride->espacios) }}" min="1" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Vehículo</label>
            <select name="vehiculo_id" class="form-select" required>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id }}" {{ (old('vehiculo_id', $ride->vehiculo_id) == $v->id) ? 'selected' : '' }}>
                        {{ $v->placa }} - {{ $v->marca }} {{ $v->modelo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" class="form-control" value="{{ old('estado', $ride->estado) }}">
        </div>

        <button class="btn btn-primary w-100">
            Actualizar ride
        </button>
    </form>

    <div class="mt-3">
        <a href="{{ route('chofer.rides.index') }}" class="small-link">&larr; Volver a mis rides</a>
    </div>

</div>
@endsection
