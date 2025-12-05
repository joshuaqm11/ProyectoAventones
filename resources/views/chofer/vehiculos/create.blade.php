@extends('layouts.app')

@section('title', 'Registrar vehículo')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Registrar vehículo</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('chofer.vehiculos.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control" value="{{ old('placa') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Año</label>
            <input type="number" name="anio" class="form-control" value="{{ old('anio') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Color</label>
            <input type="text" name="color" class="form-control" value="{{ old('color') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Capacidad</label>
            <input type="number" name="capacidad" class="form-control" value="{{ old('capacidad') }}" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fotografía</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <button class="btn btn-primary w-100">
            Guardar vehículo
        </button>
    </form>

    <div class="mt-3">
        <a href="{{ route('chofer.vehiculos.index') }}" class="small-link">&larr; Volver a mis vehículos</a>
    </div>
</div>
@endsection
