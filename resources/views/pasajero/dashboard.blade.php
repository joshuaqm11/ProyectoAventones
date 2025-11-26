@extends('layouts.app')

@section('title', 'Panel de Pasajero')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Panel de Pasajero</h1>
    <p class="subtitle">
        Hola, {{ auth()->user()->nombre }}. Aquí puedes buscar rides, hacer reservas y revisar tu historial.
    </p>

    <div class="row g-3 mt-2">

        {{-- Bloque: Buscar rides --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Buscar rides disponibles</h5>
                    <p class="card-text small text-muted mb-2">
                        Explora los rides públicos sin ver los datos del chofer. 
                        Podrás filtrar por origen, destino y fecha.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Aún no tenemos la ruta, por eso dejamos # y disabled --}}
                        <a href="#" class="btn btn-primary btn-sm disabled" aria-disabled="true">
                            Ir a búsqueda de rides (pendiente)
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
                        <a href="#" class="btn btn-outline-primary btn-sm disabled" aria-disabled="true">
                            Ver reservas activas (pendiente)
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
                        Consulta todas las reservas que has realizado: aceptadas, rechazadas y canceladas.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-outline-secondary btn-sm disabled" aria-disabled="true">
                            Ver historial (pendiente)
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
