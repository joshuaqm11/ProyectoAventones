@component('mail::message')
# Tienes una reserva pendiente

Hola {{ $reserva->ride->chofer->nombre ?? 'Chofer' }},

Tienes una solicitud de reserva pendiente desde hace un tiempo.

**Datos de la reserva:**

- Pasajero: {{ $reserva->pasajero->nombre ?? 'N/D' }}
- Ride: {{ $reserva->ride->origen ?? '' }} → {{ $reserva->ride->destino ?? '' }}
- Fecha: {{ $reserva->ride->fecha ?? '' }}
- Hora: {{ $reserva->ride->hora ?? '' }}
- Espacios solicitados: {{ $reserva->espacios ?? 1 }}

Por favor ingresa al sistema de *ProyectoAventones* para **aceptar o rechazar** esta solicitud.

@component('mail::button', ['url' => url('/')])
Ir al sistema
@endcomponent

Gracias,  
{{ config('app.name') }}
@endcomponent
