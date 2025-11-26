@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Panel de Administración</h1>
    <p class="subtitle">Bienvenido, {{ auth()->user()->nombre }}.</p>

    <div class="row g-3 mt-3">

        {{-- Administradores --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">Administradores</h5>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-primary btn-sm">
                            Ver administradores
                        </a>
                        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
                            Crear administrador
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Usuarios del sistema --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">Usuarios del sistema</h5>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary btn-sm">
                            Ver usuarios
                        </a>
                        <a href="{{ route('admin.usuarios.estado') }}" class="btn btn-outline-success btn-sm">
                            Activar / desactivar usuarios
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Script de reservas (solo referencia, sin rutas web) --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">Script de reservas pendientes</h5>

                    <p class="mb-2 small text-muted">
                        Esta funcionalidad se ejecuta mediante un comando de consola
                        que revisa las reservas pendientes y envía correos a los choferes.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <button type="button" class="btn btn-outline-warning btn-sm" disabled>
                            Ver reservas pendientes (consola)
                        </button>
                        <button type="button" class="btn btn-outline-dark btn-sm" disabled>
                            Ejecutar script por consola
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
    </form>

</div>
@endsection
