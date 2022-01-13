<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VotoQuestaoNotification extends Notification
{
    use Queueable;

    private $questao;
    private $idAutorVoto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($questao, $autorVoto) {
        $this->questao = $questao;
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
            'idQuestao' => $this->questao->id,
            'idAutorQuestao' => $this->questao->autor,
            'idAutorVoto' => $this->idAutorVoto
        ];
    }
}
