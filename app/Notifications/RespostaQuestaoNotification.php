<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Resposta;

class RespostaQuestaoNotification extends Notification
{
    use Queueable;

    private $resposta;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Resposta $resposta) {
        $this->resposta = $resposta;
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
    public function toArray($notifiable) {
        return [
            'idQuestao' => $this->resposta->questao->id,
            'idAutorResposta' => $this->resposta->criador->utilizador->id,
            'idResposta' => $this->resposta->id
        ];
    }
}
