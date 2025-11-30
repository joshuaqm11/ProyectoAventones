<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivarCuentaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $urlActivacion = route('activar', $this->usuario->token_activacion);

        return $this->subject('Activa tu cuenta en ProyectoAventones')
            ->view('emails.activar_cuenta')
            ->with([
                'usuario'       => $this->usuario,
                'urlActivacion' => $urlActivacion,
            ]);
    }
}
