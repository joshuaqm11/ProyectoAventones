@extends('layouts.app')

@section('title', 'Reservas activas')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Mis reservas activas</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($reservas->isEmpty())
        <div class="alert alert-info">
            No tienes reservas activas.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm align-middle">
                <thead>
                    <tr>
                        <th>Ride</th>
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
                            <td>{{ $r->ride->origen }} → {{ $r->ride->destino }}</td>
                            <td>{{ $r->ride->fecha }}</td>
                            <td>{{ $r->ride->hora }}</td>
                            <td>{{ $r->cantidad }}</td>
                            <td>{{ ucfirst($r->estado) }}</td>
                            <td class="text-end">
                                @if(in_array($r->estado, ['pendiente','aceptada']))
                                    <form method="POST"
                                          action="{{ route('pasajero.reservas.cancelar', $r) }}"
                                          onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?')">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('pasajero.dashboard') }}" class="small-link">
            &larr; Volver al panel de pasajero
        </a>
    </div>
</div>
@endsection
