@extends('layouts.app')

@section('title', 'Mis vehículos')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Mis vehículos</h1>
    <p class="subtitle">Aquí ves y gestionas los vehículos registrados en tu cuenta.</p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('vehiculos.create') }}" class="btn btn-primary btn-sm">
            + Registrar vehículo
        </a>
    </div>

    @if($vehiculos->isEmpty())
        <p class="text-muted small">Aún no tienes vehículos registrados.</p>
    @else
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca / Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Capacidad</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $v)
                    <tr>
                        <td>{{ $v->placa }}</td>
                        <td>{{ $v->marca }} {{ $v->modelo }}</td>
                        <td>{{ $v->anio }}</td>
                        <td>{{ $v->color }}</td>
                        <td>{{ $v->capacidad }}</td>
                        <td>
                            @if($v->fotografia)
                                <img src="{{ asset('storage/'.$v->fotografia) }}" alt="Foto" style="width:60px;">
                            @else
                                <span class="text-muted small">Sin foto</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-3">
        <a href="{{ route('chofer.dashboard') }}" class="small-link">&larr; Volver al panel de chofer</a>
    </div>

</div>
@endsection
