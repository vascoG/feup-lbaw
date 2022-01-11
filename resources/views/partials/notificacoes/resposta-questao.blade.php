@extends('partials.notificacoes.base')

@section('conteudo-notificacao')
    <p>O utilizador {{ $nomeUtilizador }} respondeu à questão: <a class="link-primary notificacao-underline" href="{{ route('questao', $idQuestao) }}">{{ $tituloQuestao }}</a></p>
@overwrite
