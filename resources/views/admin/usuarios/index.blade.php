@extends('layouts.app')

@section('title', 'Usuarios del sistema')

@section('content')
<div class="auth-card">

    <h1 class="brand-title">Usuarios del sistema</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($usuarios->isEmpty())
        <p class="text-muted small">No hay usuarios registrados.</p>
    @else
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                        <td>{{ $u->correo }}</td>
                        <td>{{ ucfirst($u->tipo) }}</td>
                        <td>{{ $u->estado }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.usuarios.toggle-estado', $u) }}">
                                @csrf
                                <button class="btn btn-sm {{ $u->estado === 'activo' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $u->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-3">
        <a href="{{ route('admin.dashboard') }}" class="small-link">&larr; Volver al panel de administración</a>
    </div>

</div>
@endsection
