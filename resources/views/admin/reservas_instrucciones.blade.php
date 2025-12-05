@extends('layouts.app')

@section('title', 'Instrucciones script reservas')

@section('content')
<div class="page-card">

    <h1 class="brand-title">Script de reservas pendientes</h1>
    <p class="subtitle">
        Guía para ejecutar el comando en consola.
    </p>

    <div class="mb-3 small">
        <p>
            Este comando revisa todas las reservas con estado <strong>pendiente</strong>
            que tienen más de <strong>X minutos</strong> de haberse creado y envía un correo
            al chofer correspondiente para avisarle que tiene solicitudes por revisar.
        </p>

        <ol>
            <li>
                Abre una consola en la carpeta del proyecto:
                <br>
                <code>C:\xampp\htdocs\ProyectoAventones</code>
            </li>
            <li>
                Asegúrate de que el servidor de Laravel pueda seguir corriendo
                (puedes tener otra ventana con <code>php artisan serve</code>).
            </li>
            <li>
                Ejecuta el siguiente comando, reemplazando <code>X</code> por la cantidad
                de minutos que quieres usar como umbral (por ejemplo, <code>30</code>):
            </li>
        </ol>

        <div class="bg-light border rounded p-2 mb-3">
            <code>php artisan reservas:notificar X</code>
        </div>

        <p class="small text-muted mb-0">
            Ejemplo: para notificar reservas que llevan más de 30 minutos pendientes:
        </p>
        <div class="bg-light border rounded p-2 mt-1 mb-3">
            <code>php artisan reservas:notificar 30</code>
        </div>

        <p class="small text-muted">
            Cada vez que ejecutes el comando, se enviarán correos únicamente
            a los choferes que tengan reservas pendientes que cumplan con ese criterio.
        </p>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Volver al panel de administración
        </a>
    </div>

</div>
@endsection
