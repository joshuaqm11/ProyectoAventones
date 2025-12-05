@extends('layouts.app')

@section('title', 'Mis rides')

@section('content')
<<div class="page-card">

    <h1 class="brand-title">Mis rides</h1>
    <p class="subtitle">
        Aquí verás los rides que has publicado como chofer.
    </p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('chofer.rides.create') }}" class="btn btn-primary btn-sm">
            + Crear nuevo ride
        </a>
    </div>

    @if($rides->isEmpty())
        <div class="alert alert-info small">
            Aún no tienes rides creados. Usa el botón <strong>“+ Crear nuevo ride”</strong> para publicar uno.
        </div>
    @else
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Vehículo</th>
                    <th>Precio</th>
                    <th>Espacios</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rides as $r)
                    <tr>
                        <td>{{ $r->origen }}</td>
                        <td>{{ $r->destino }}</td>
                        <td>{{ $r->fecha }}</td>
                        <td>{{ $r->hora }}</td>
                        <td>{{ $r->vehiculo->placa ?? '-' }}</td>
                        <td>{{ number_format($r->precio, 0) }}</td>
                        <td>{{ $r->espacios }}</td>
                        <td>{{ $r->estado }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('chofer.rides.edit', $r) }}" class="btn btn-outline-primary btn-sm">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('chofer.rides.destroy', $r) }}"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este ride?')">
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
