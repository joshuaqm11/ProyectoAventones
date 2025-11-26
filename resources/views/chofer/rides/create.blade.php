@extends('layouts.app')

@section('title', 'Crear ride')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Crear nuevo ride</h1>
    <p class="subtitle">
        Define origen, destino, fecha, hora, vehículo y espacios disponibles.
    </p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('chofer.rides.store') }}">
        @csrf

        <div class="mb-2">
            <label class="form-label">Origen</label>
            <input type="text" name="origen" class="form-control" value="{{ old('origen') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Destino</label>
            <input type="text" name="destino" class="form-control" value="{{ old('destino') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Fecha de salida</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Hora de salida</label>
            <input type="time" name="hora" class="form-control" value="{{ old('hora') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Precio por espacio</label>
            <input type="number" name="precio" class="form-control" value="{{ old('precio') }}" min="0" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Espacios disponibles</label>
            <input type="number" name="espacios" class="form-control" value="{{ old('espacios') }}" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Vehículo</label>
            <select name="vehiculo_id" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach($vehiculos as $v)
                    <option value="{{ $v->id }}" {{ old('vehiculo_id') == $v->id ? 'selected' : '' }}>
                        {{ $v->placa }} - {{ $v->marca }} {{ $v->modelo }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary w-100">
            Guardar ride
        </button>
    </form>

    <div class="mt-3">
        <a href="{{ route('chofer.rides.index') }}" class="small-link">&larr; Volver a mis rides</a>
    </div>
</div>
@endsection
