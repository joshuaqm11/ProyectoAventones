{{-- resources/views/admin/usuarios/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear administrador')

@section('content')
<div class="page-card">

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

    <form method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf

        <div class="mb-2">
            <label class="form-label">Nombre</label>
            <input
                type="text"
                name="nombre"
                class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre') }}"
                required
            >
            @error('nombre')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Apellido</label>
            <input
                type="text"
                name="apellido"
                class="form-control @error('apellido') is-invalid @enderror"
                value="{{ old('apellido') }}"
                required
            >
            @error('apellido')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Cédula</label>
            <input
                type="text"
                name="cedula"
                class="form-control @error('cedula') is-invalid @enderror"
                value="{{ old('cedula') }}"
                required
                maxlength="9"
                oninput="this.value = this.value.replace(/[^0-9]/g,'');"
            >
            @error('cedula')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Correo</label>
            <input
                type="email"
                name="correo"
                class="form-control @error('correo') is-invalid @enderror"
                value="{{ old('correo') }}"
                required
            >
            @error('correo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Teléfono</label>
            <input
                type="text"
                name="telefono"
                class="form-control @error('telefono') is-invalid @enderror"
                value="{{ old('telefono') }}"
                required
                maxlength="8"
                oninput="this.value = this.value.replace(/[^0-9]/g,'');"
            >
            @error('telefono')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="form-label">Contraseña</label>
            <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
            >
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-primary w-100">Guardar administrador</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('admin.usuarios.index') }}" class="small-link">
            &larr; Volver a administradores
        </a>
    </div>

</div>
@endsection
