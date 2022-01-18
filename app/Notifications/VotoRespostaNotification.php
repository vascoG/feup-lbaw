<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VotoRespostaNotification extends Notification
{
    use Queueable;

    private $resposta;
    private $idAutorVoto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resposta, $autorVoto) {
        $this->resposta = $resposta;
        $this->idAutorVoto = $autorVoto->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'idResposta' => $this->resposta->id,
            'idAutorVoto' => $this->idAutorVoto
        ];
    }
}
