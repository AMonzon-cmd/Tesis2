<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarContrasenia extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Restablecer contraseña';
    public $nombre = "";
    public $token = "";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $token)
    {
        $this->nombre = $nombre;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('restablecerPass');
    }
}
