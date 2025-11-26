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

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Activa tu cuenta en ProyectoAventones')
                    ->view('emails.activar_cuenta');
    }
}
