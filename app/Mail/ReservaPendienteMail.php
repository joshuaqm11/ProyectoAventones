<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaPendienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;

    /**
     * Create a new message instance.
     */
    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Tienes solicitudes de reserva pendientes')
                    ->markdown('emails.reservas.pendiente', [
                        'reserva' => $this->reserva,
                    ]);
    }
}
