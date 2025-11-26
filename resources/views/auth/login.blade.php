@extends('layouts.app')

@section('title', 'Login - ProyectoAventones')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">ProyectoAventones</h1>
    <p class="subtitle">Inicia sesión para continuar</p>

    {{-- Mensajes --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}"
                class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password"
                class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Entrar
        </button>

    </form>

    <hr>

    <div class="text-center">
        <p>¿No tienes cuenta?</p>
        <a href="{{ route('registro.chofer') }}" class="btn btn-outline-primary btn-sm me-2">
            Registrar como chofer
        </a>
        <a href="{{ route('registro.pasajero') }}" class="btn btn-outline-secondary btn-sm">
            Registrar como pasajero
        </a>
    </div>

</div>
@endsection
