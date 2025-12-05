@extends('layouts.app')

@section('title', 'Administradores')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Administradores</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
            + Crear administrador
        </a>
    </div>

    @if($admins->isEmpty())
        <p class="text-muted small">No hay administradores registrados aparte de ti.</p>
    @else
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cédula</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $a)
                    <tr>
                        <td>{{ $a->nombre }} {{ $a->apellido }}</td>
                        <td>{{ $a->correo }}</td>
                        <td>{{ $a->cedula }}</td>
                        <td>{{ $a->estado }}</td>
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
