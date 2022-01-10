@switch($notificacao->type)
    @case('App\Notifications\RespostaQuestao')
        @include('partials.cards.notificacoes.resposta-questao', ['notificacao', $notificacao])
        @break
@endswitch