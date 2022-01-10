@extends('partials.cards.notificacoes.base')

@section('conteudo-notificacao')
    <p>O utilizador {{ App\Models\Utilizador::find($notificacao->data['idAutorResposta'])->nome_utilizador }} respondeu à sua <a class="link-primary notificacao-underline" href="{{ route('questao', $notificacao->data['idQuestao']) }}">questão</a></p>
@endsection