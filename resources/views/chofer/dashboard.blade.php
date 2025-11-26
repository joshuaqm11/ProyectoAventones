@extends('layouts.app')

@section('title', 'Panel de Chofer')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Panel de Chofer</h1>
    <p class="subtitle">
        Hola, {{ auth()->user()->nombre }}. Desde aquí administras tus vehículos, rides y reservas.
    </p>

    <div class="row g-3 mt-2">

            {{-- Bloque: Vehículos --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Mis vehículos</h5>
                    <p class="card-text small text-muted mb-2">
                        Registra y administra los vehículos que usarás para tus rides.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('chofer.vehiculos.index') }}" class="btn btn-outline-primary btn-sm">
                            Ver / gestionar vehículos
                        </a>
                        <a href="{{ route('chofer.vehiculos.create') }}" class="btn btn-primary btn-sm">
                            Registrar nuevo vehículo
                        </a>
                    </div>
                </div>
            </div>
        </div>


        {{-- Bloque: Rides --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Mis rides</h5>
                    <p class="card-text small text-muted mb-2">
                        Crea, edita y elimina rides. Asocia cada ride a uno de tus vehículos.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Rutas de rides del chofer --}}
                        <a href="{{ route('chofer.rides.index') }}" class="btn btn-outline-primary btn-sm">
                            Ver rides publicados
                        </a>
                        <a href="{{ route('chofer.rides.create') }}" class="btn btn-primary btn-sm">
                            Crear nuevo ride
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bloque: Reservas recibidas --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Reservas de mis rides</h5>
                    <p class="card-text small text-muted mb-2">
                        Visualiza las reservas asociadas a tus rides y acepta o rechaza solicitudes.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Por ahora solo maquetado, sin rutas definidas --}}
                        <a href="#" class="btn btn-warning btn-sm disabled" aria-disabled="true">
                            Ver reservas pendientes (pendiente)
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm disabled" aria-disabled="true">
                            Ver todas las reservas (pendiente)
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Cerrar sesión --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
    </form>

</div>
@endsection
