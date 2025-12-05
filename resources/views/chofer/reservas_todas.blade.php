@extends('layouts.app')

@section('title', 'Todas las reservas')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Todas las reservas de mis rides</h1>
    <p class="subtitle">
        Aquí ves <strong>todas</strong> las reservas asociadas a tus rides, sin importar el estado.
    </p>

    @if($reservas->isEmpty())
        <div class="alert alert-info">
            Aún no tienes reservas en tus rides.
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

        <a href="{{ route('chofer.reservas.pendientes') }}" class="small-link">
            Ver solo pendientes &rarr;
        </a>
    </div>

</div>
@endsection
