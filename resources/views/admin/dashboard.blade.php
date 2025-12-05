{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Panel de Administración</h1>
    <p class="subtitle">
        Bienvenido, Admin.
    </p>

    <div class="row g-3 mt-2">

        {{-- Bloque: Administradores --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Administradores</h5>
                    <p class="card-text small text-muted mb-2">
                        Gestiona las cuentas con rol de administrador.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.admins.index') }}"
                           class="btn btn-outline-primary btn-sm">
                            Ver administradores
                        </a>
                        <a href="{{ route('admin.admins.create') }}"
                           class="btn btn-primary btn-sm">
                            Crear administrador
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bloque: Usuarios del sistema --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Usuarios del sistema</h5>
                    <p class="card-text small text-muted mb-2">
                        Consulta todos los usuarios registrados.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- SOLO VER USUARIOS (sin activar/desactivar) --}}
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="btn btn-outline-secondary btn-sm">
                            Ver usuarios
                        </a>

                        {{-- Vista para activar / desactivar usuarios --}}
                        <a href="{{ route('admin.usuarios.estado') }}"
                           class="btn btn-outline-success btn-sm">
                            Activar / desactivar usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>

            {{-- Bloque: Script de reservas pendientes --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">Script de reservas pendientes</h5>
                    <p class="card-text small text-muted mb-2">
                        Este script se ejecuta desde la consola y envía correos a los choferes
                        cuando tienen solicitudes de reserva pendientes con más de X minutos
                        de haberse creado.
                    </p>

                    <a href="{{ route('admin.reservas.instrucciones') }}"
                    class="btn btn-warning btn-sm">
                        Ver instrucciones para ejecutar
                    </a>
                </div>
            </div>
        </div>


    {{-- Cerrar sesión --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
    </form>

</div>

{{-- MODAL con instrucciones del comando --}}
<div class="modal fade" id="modalReservasPendientes" tabindex="-1"
     aria-labelledby="modalReservasPendientesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReservasPendientesLabel">
                    Cómo ejecutar el script de reservas pendientes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <ol class="small">
                    <li>Abre una consola en la carpeta del proyecto:
                        <code>C:\xampp\htdocs\ProyectoAventones</code>.
                    </li>
                    <li>Asegúrate de que el servidor de Laravel esté detenido
                        (si está corriendo en otra ventana).
                    </li>
                    <li>Ejecuta el siguiente comando, reemplazando
                        <code>X</code> por la cantidad de minutos, por ejemplo <code>30</code>:
                    </li>
                </ol>

                <div class="bg-light border rounded p-2 mb-2">
                    <code>php artisan reservas:notificar X</code>
                </div>

                <p class="small text-muted mb-0">
                    El comando buscará las reservas con más de <code>X</code> minutos
                    en estado <strong>pendiente</strong> y enviará un correo a cada chofer
                    avisando que tiene solicitudes por revisar.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
