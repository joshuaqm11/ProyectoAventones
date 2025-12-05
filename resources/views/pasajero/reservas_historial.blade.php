@extends('layouts.app')

@section('title', 'Historial de reservas')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Historial de reservas</h1>

    @if($reservas->isEmpty())
        <div class="alert alert-info">
            Aún no tienes reservas en tu historial.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm align-middle">
                <thead>
                    <tr>
                        <th>Ride</th>
                        <th>Fecha</th>
                        <th>Cant.</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $r)
                        <tr>
                            <td>{{ $r->ride->origen }} → {{ $r->ride->destino }}</td>
                            <td>{{ $r->ride->fecha }}</td>
                            <td>{{ $r->cantidad }}</td>
                            <td>{{ ucfirst($r->estado) }}</td>
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
