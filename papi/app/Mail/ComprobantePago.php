<?php

namespace App\Mail;

use App\Models\Pago;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobantePago extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Pago de servicio";
    public $pago = "";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pago)
    {
        $this->subject = $this->subject . " " . $pago->servicio->nombre;
        $this->pago = $pago;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('comprobantePago');
    }
}
