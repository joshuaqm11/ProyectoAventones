@extends('layouts.app')

@section('title', 'Usuarios del sistema')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Usuarios del sistema</h1>
    <p class="subtitle">Lista completa de usuarios registrados.</p>

    @if($usuarios->isEmpty())
        <div class="alert alert-info small">No hay usuarios registrados.</div>
    @else
        <table class="table table-sm table-striped align-middle mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                        <td>{{ $u->correo }}</td>
                        <td>{{ ucfirst($u->tipo) }}</td>
                        <td>
                            @if($u->estado === 'activo')
                                <span class="badge text-bg-success">Activo</span>
                            @elseif($u->estado === 'inactivo')
                                <span class="badge text-bg-secondary">Inactivo</span>
                            @else
                                <span class="badge text-bg-warning">Pendiente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-3">
        <a href="{{ route('admin.dashboard') }}" class="small-link">
            &larr; Volver al panel de administración
        </a>
    </div>

</div>
@endsection
