@extends('layouts.app')

@section('title', 'Reservas pendientes')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Reservas pendientes de mis rides</h1>
    <p class="subtitle">
        Aquí ves todas las reservas en estado <strong>pendiente</strong> para los rides que tú publicaste.
    </p>

    @if($reservas->isEmpty())
        <div class="alert alert-info">
            No tienes reservas pendientes en tus rides.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm align-middle">
                <thead>
                    <tr>
                        <th>Ride</th>
                        <th>Pasajero</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cant.</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $r)
                        <tr>
                            <td>
                                {{ $r->ride->origen }} → {{ $r->ride->destino }}
                            </td>
                            <td>
                                {{ $r->pasajero->nombre ?? 'N/D' }}
                                {{ $r->pasajero->apellido ?? '' }}
                            </td>
                            <td>{{ $r->ride->fecha }}</td>
                            <td>{{ $r->ride->hora }}</td>
                            <td>{{ $r->cantidad }}</td>
                            <td>{{ ucfirst($r->estado) }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    {{-- ACEPTAR --}}
                                    <form method="POST"
                                          action="{{ route('chofer.reservas.aceptar', $r) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">
                                            Aceptar
                                        </button>
                                    </form>

                                    {{-- RECHAZAR --}}
                                    <form method="POST"
                                          action="{{ route('chofer.reservas.rechazar', $r) }}"
                                          onsubmit="return confirm('¿Seguro que deseas rechazar esta reserva?')">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm">
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('chofer.dashboard') }}" class="small-link">
            &larr; Volver al panel de chofer
        </a>

        <a href="{{ route('chofer.reservas.todas') }}" class="small-link">
            Ver todas las reservas &rarr;
        </a>
    </div>

</div>
@endsection
