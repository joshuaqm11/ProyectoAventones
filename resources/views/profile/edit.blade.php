@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
<div class="page-card">

    @include('components.foto_perfil')
    <h1 class="brand-title">Editar mi perfil</h1>
    <p class="subtitle">Actualiza tu información personal.</p>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito (por si se usa) --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST"
          action="
            @if(auth()->user()->tipo === 'chofer')
                {{ route('chofer.perfil.update') }}
            @elseif(auth()->user()->tipo === 'pasajero')
                {{ route('pasajero.perfil.update') }}
            @else
                {{ route('admin.dashboard') }} {{-- no debería llegar aquí normalmente --}}
            @endif
          "
          enctype="multipart/form-data">
        @csrf

        <div class="row g-2">
            <div class="col-md-6 mb-2">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre"
                       class="form-control"
                       value="{{ old('nombre', $usuario->nombre) }}"
                       required>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido"
                       class="form-control"
                       value="{{ old('apellido', $usuario->apellido) }}"
                       required>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula"
                       class="form-control"
                       value="{{ old('cedula', $usuario->cedula) }}"
                       required>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                       class="form-control"
                       value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}">
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Correo</label>
                <input type="email" name="correo"
                       class="form-control"
                       value="{{ old('correo', $usuario->correo) }}"
                       required>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono"
                       class="form-control"
                       value="{{ old('telefono', $usuario->telefono) }}">
            </div>

            <div class="col-md-12 mb-2">
                <label class="form-label">Foto de perfil</label>
                <input type="file" name="foto" class="form-control">

                @if($usuario->foto)
                    <div class="mt-2">
                        <small class="text-muted d-block">Foto actual:</small>
                        <img src="{{ asset('storage/'.$usuario->foto) }}"
                             alt="Foto de perfil"
                             style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            {{-- Botón Cancelar: vuelve al dashboard según tipo --}}
            @if(auth()->user()->tipo === 'chofer')
                <a href="{{ route('chofer.dashboard') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            @elseif(auth()->user()->tipo === 'pasajero')
                <a href="{{ route('pasajero.dashboard') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            @endif

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>
        </div>
    </form>

</div>
@endsection
