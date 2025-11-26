@extends('layouts.app')

@section('title', 'Registrar Chofer')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Registro de Chofer</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('registro.chofer.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cédula</label>
            <input type="text" name="cedula" value="{{ old('cedula') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Registrarme como chofer
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>

</div>
@endsection
