@extends('layouts.app')

@section('title', 'Panel de Pasajero')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Panel de Pasajero</h1>
    <p class="subtitle">
        Hola, {{ auth()->user()->nombre }}. Aquí puedes buscar rides, hacer reservas y ver tu historial.
    </p>

    <div class="row g-3 mt-2">

        {{-- Bloque: Buscar rides públicos --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Buscar rides disponibles</h5>
                    <p class="card-text small text-muted mb-2">
                        Explora los rides públicos sin ver los datos del chofer. 
                        Podrás filtrar por origen, destino y fecha.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Ruta a la pantalla pública de búsqueda de rides --}}
                        <a href="{{ route('rides.publico') }}" class="btn btn-primary btn-sm">
                            Ir a búsqueda de rides
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bloque: Reservas activas --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Mis reservas activas</h5>
                    <p class="card-text small text-muted mb-2">
                        Visualiza las reservas en estado pendiente o aceptada, 
                        y cancela las que ya no necesites.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Ruta para listar reservas activas del pasajero --}}
                        <a href="{{ route('pasajero.reservas.activas') }}" class="btn btn-outline-primary btn-sm">
                            Ver reservas activas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bloque: Historial de reservas --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Historial de reservas</h5>
                    <p class="card-text small text-muted mb-2">
                        Consulta todas las reservas que has realizado (aceptadas, rechazadas, canceladas).
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Ruta para histórico de reservas --}}
                        <a href="{{ route('pasajero.reservas.historial') }}" class="btn btn-outline-secondary btn-sm">
                            Ver historial de reservas
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
