@extends('layouts.app')

@section('title', 'Panel de Pasajero')

@section('content')
<div class="page-card">

    <div class="mb-3 text-end">
        <a href="{{ route('pasajero.perfil.edit') }}" class="btn btn-outline-secondary btn-sm">
            Editar mi perfil
        </a>
    </div>

    @include('components.foto_perfil')

    <h1 class="brand-title">Panel de Pasajero</h1>
    <p class="subtitle">
        Hola, {{ auth()->user()->nombre ?? 'pasajero' }}. Aquí puedes buscar rides,
        hacer reservas y revisar tu historial.
    </p>

    {{-- Buscar rides --}}
    <div class="card mb-3 p-3">
        <h5>Buscar rides disponibles</h5>
        <p class="small text-muted">
            Explora los rides publicados por los choferes y reserva espacios.
        </p>
        <a href="{{ route('pasajero.rides.buscar') }}" class="btn btn-primary btn-sm">
            Ir a búsqueda de rides
        </a>
    </div>

    {{-- Reservas activas --}}
    <div class="card mb-3 p-3">
        <h5>Mis reservas activas</h5>
        <p class="small text-muted">
            Revisa tus reservas pendientes o aceptadas y cancela las que no necesites.
        </p>
        <a href="{{ route('pasajero.reservas.activas') }}" class="btn btn-outline-primary btn-sm">
            Ver reservas activas
        </a>
    </div>

    {{-- Historial --}}
    <div class="card mb-3 p-3">
        <h5>Historial de reservas</h5>
        <p class="small text-muted">
            Consulta las reservas que has realizado anteriormente.
        </p>
        <a href="{{ route('pasajero.reservas.historial') }}" class="btn btn-outline-secondary btn-sm">
            Ver historial de reservas
        </a>
    </div>

    {{-- BOTÓN CERRAR SESIÓN ABAJO --}}
    <div class="text-center mt-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger">
                Cerrar sesión
            </button>
        </form>
    </div>

</div>
@endsection
