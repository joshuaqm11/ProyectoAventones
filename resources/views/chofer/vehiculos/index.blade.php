@extends('layouts.app')

@section('title', 'Mis vehículos')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Mis vehículos</h1>
    <p class="subtitle">
        Aquí verás los vehículos que tienes registrados como chofer.
    </p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('chofer.vehiculos.create') }}" class="btn btn-primary btn-sm">
            + Registrar vehículo
        </a>
    </div>

    @if($vehiculos->isEmpty())
        <div class="alert alert-info small">
            Aún no tienes vehículos registrados.
        </div>
    @else
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Capacidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $v)
                    <tr>
                        <td>
                            @if($v->fotografia)
                                <img src="{{ asset('storage/'.$v->fotografia) }}"
                                     alt="Foto vehículo"
                                     style="width:60px; height:40px; object-fit:cover;">
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $v->placa }}</td>
                        <td>{{ $v->marca }}</td>
                        <td>{{ $v->modelo }}</td>
                        <td>{{ $v->anio }}</td>
                        <td>{{ $v->color }}</td>
                        <td>{{ $v->capacidad }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('chofer.vehiculos.edit', $v) }}" class="btn btn-outline-primary btn-sm">
                                Editar
                            </a>
                            <form method="POST"
                                  action="{{ route('chofer.vehiculos.destroy', $v) }}"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este vehículo?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
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
