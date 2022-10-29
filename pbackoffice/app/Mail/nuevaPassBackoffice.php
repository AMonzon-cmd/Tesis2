<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class nuevaPassBackoffice extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Nueva contraseña backoffice';
    public $pass = "";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Autenticacion.restablecer');
    }
}
