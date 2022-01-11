@switch($notificacao->type)
    @case('App\Notifications\RespostaQuestaoNotification')
        @include('partials.notificacoes.resposta-questao', [
            'nomeUtilizador' => App\Models\Utilizador::find($notificacao->data['idAutorResposta'])->nome_utilizador,
            'idQuestao' => $notificacao->data['idQuestao'],
            'tituloQuestao' => App\Models\Questao::find($notificacao->data['idQuestao'])->titulo
        ])
        @break
    @default
        <li>Notificação inválida</li>
@endswitch