@extends('layouts.app')

@section('title', 'Rides disponibles')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Rides disponibles</h1>
    <p class="subtitle">
        Consulta los rides publicados sin necesidad de iniciar sesión.
        <br>
        Solo pasajeros registrados pueden reservar.
    </p>

    {{-- Mensaje sobre reservas --}}
    <div class="alert alert-info small">
        @auth
            @if(auth()->user()->tipo === 'pasajero')
                Para reservar un ride, ingresa a tu
                <a href="{{ route('pasajero.dashboard') }}" class="fw-bold">panel de pasajero</a>.
            @else
                Solo los usuarios con rol <strong>pasajero</strong> pueden reservar rides.
            @endif
        @else
            Para reservar un ride debes registrarte e iniciar sesión como pasajero.
        @endauth
    </div>

    {{-- Info del orden actual --}}
    @if(isset($ordenActual) && isset($dirActual))
    <div class="alert alert-secondary small text-center mb-3">
        Ordenando por:
        <strong>
            @switch($ordenActual)
                @case('origen') Origen @break
                @case('destino') Destino @break
                @default Fecha
            @endswitch
        </strong>
        en orden
        <strong>
            {{ $dirActual == 'asc' ? 'ascendente' : 'descendente' }}
        </strong>
    </div>
@endif

   {{-- FILTROS Y ORDEN --}}
<form method="GET" class="row g-2 mb-3 align-items-end">

    <div class="col-md-3">
        <label class="form-label small">Origen</label>
        <input name="origen"
               class="form-control"
               placeholder="Ej: San José"
               value="{{ request('origen') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label small">Destino</label>
        <input name="destino"
               class="form-control"
               placeholder="Ej: Alajuela"
               value="{{ request('destino') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label small">Ordenar por</label>
        <select name="orden" class="form-select">
            <option value="fecha"   {{ $ordenActual == 'fecha' ? 'selected' : '' }}>Fecha</option>
            <option value="origen"  {{ $ordenActual == 'origen' ? 'selected' : '' }}>Origen</option>
            <option value="destino" {{ $ordenActual == 'destino' ? 'selected' : '' }}>Destino</option>
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label small">Dirección</label>
        <select name="dir" class="form-select">
            <option value="asc"  {{ $dirActual == 'asc' ? 'selected' : '' }}>Ascendente</option>
            <option value="desc" {{ $dirActual == 'desc' ? 'selected' : '' }}>Descendente</option>
        </select>
    </div>

    <div class="col-md-1 d-grid">
        <button class="btn btn-primary btn-sm">Filtrar</button>
    </div>

</form>


    {{-- RESULTADOS --}}
    @if($rides->isEmpty())
        <div class="alert alert-info">
            No se encontraron rides con esos filtros.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio</th>
                        <th>Espacios</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- ENLACES DE NAVEGACIÓN --}}
    <div class="mt-3">
        @auth
            @if(auth()->user()->tipo === 'pasajero')
                <a href="{{ route('pasajero.dashboard') }}" class="small-link">
                    &larr; Ir al panel de pasajero para reservar
                </a>
            @elseif(auth()->user()->tipo === 'chofer')
                <a href="{{ route('chofer.dashboard') }}" class="small-link">
                    &larr; Ir al panel de chofer
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="small-link">
                &larr; Iniciar sesión
            </a>
        @endauth
    </div>

</div>
@endsection
