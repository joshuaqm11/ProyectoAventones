@extends('layouts.app')

@section('title', 'Usuarios del sistema')

@section('content')
<div class="page-card">

    <h1 class="brand-title mb-3">Usuarios del sistema</h1>
    <p class="subtitle mb-4">
        Desde aquí puedes activar o desactivar cualquier usuario.
    </p>

    @if(session('status'))
        <div class="alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    {{-- 👇 muy importante: envolvemos la tabla --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle table-sm mb-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                        <td class="text-break">{{ $u->correo }}</td>
                        <td>{{ ucfirst($u->tipo) }}</td>
                        <td>
                            @if($u->estado === 'activo')
                                <span class="badge bg-success">Activo</span>
                            @elseif($u->estado === 'inactivo')
                                <span class="badge bg-secondary">Inactivo</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.usuarios.estado', $u) }}">
                                @csrf
                                @method('PATCH')

                                @if($u->estado === 'activo')
                                    <button class="btn btn-outline-danger btn-sm">
                                        Desactivar
                                    </button>
                                @else
                                    <button class="btn btn-outline-success btn-sm">
                                        Activar
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="small-link">&larr; Volver al panel de administración</a>

</div>
@endsection
