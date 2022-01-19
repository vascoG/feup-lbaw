@extends('partials.notificacoes.base')

@section('conteudo-notificacao')
    <p>O utilizador {{ $nomeUtilizador }} deu gosto à sua resposta na questão: <a class="link-primary notificacao-underline" href="{{ route('questao', $idQuestao) }}">{{ $tituloQuestao }}</a></p>
@overwrite