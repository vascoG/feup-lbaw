<?php

namespace App\Mail;

use App\Models\Utilizador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperaConta extends Mailable
{
    use Queueable, SerializesModels;

    private $utilizador;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Utilizador $utilizador, String $token) {
        $this->utilizador = $utilizador;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.auth.recuperacao', [
            'usr' => $this->utilizador,
            'token' => $this->token
        ]);
    }
}
