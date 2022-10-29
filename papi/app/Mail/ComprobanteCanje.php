<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobanteCanje extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Canje de producto";
    public $canje;
    public $producto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($canje)
    {
        $this->canje = $canje;
        $this->producto = $canje->producto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('comprobanteCanje');
    }
}
