@extends('layouts.app')

@section('title', 'Crear administrador')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Crear administrador</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

        <div class="mb-2">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Cédula</label>
            <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>

        <div class="mb-2">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Guardar administrador</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('admin.admins.index') }}" class="small-link">&larr; Volver a administradores</a>
    </div>

</div>
@endsection
