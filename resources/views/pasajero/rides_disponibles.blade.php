@extends('layouts.app')

@section('title', 'Rides disponibles')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Buscar rides disponibles</h1>
    <p class="subtitle">
        Usa los filtros para encontrar un ride y reserva la cantidad de espacios que necesites.
    </p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Filtros --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input name="origen"
                   class="form-control"
                   placeholder="Origen"
                   value="{{ request('origen') }}">
        </div>

        <div class="col-md-4">
            <input name="destino"
                   class="form-control"
                   placeholder="Destino"
                   value="{{ request('destino') }}">
        </div>

        <div class="col-md-3">
            <input type="date"
                   name="fecha"
                   class="form-control"
                   value="{{ request('fecha') }}">
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-primary btn-sm">Buscar</button>
        </div>
    </form>

    @if($rides->isEmpty())
        <div class="alert alert-info">
            No se encontraron rides con esos filtros.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm align-middle">
                <thead>
                    <tr>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio</th>
                        <th>Espacios</th>
                        <th class="text-end">Reservar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rides as $ride)
                        <tr>
                            <td>{{ $ride->origen }}</td>
                            <td>{{ $ride->destino }}</td>
                            <td>{{ $ride->fecha }}</td>
                            <td>{{ $ride->hora }}</td>
                            <td>₡{{ number_format($ride->precio, 0, ',', '.') }}</td>
                            <td>{{ $ride->espacios }}</td>
                            <td class="text-end">
                                <form method="POST"
                                      action="{{ route('pasajero.rides.reservar', $ride) }}"
                                      class="d-inline-flex gap-1">
                                    @csrf
                                    <input type="number"
                                           name="cantidad"
                                           class="form-control form-control-sm"
                                           style="width: 70px;"
                                           min="1"
                                           max="{{ $ride->espacios }}"
                                           value="1">
                                    <button class="btn btn-success btn-sm">
                                        Reservar
                                    </button>
                                </form>
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
