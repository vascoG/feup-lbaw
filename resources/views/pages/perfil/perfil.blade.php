@extends('layouts.geral')

@section('conteudo')
<div id="corpo-perfil">
    <h1 id="perfil-nome-utilizador">{{ $usr->nome }}</h1>
    <div id="perfil-caracterizacao">
        <div id="perfil-avatar-container">
            <img id="perfil-avatar" src="{{ asset($usr->imagem_perfil) }}">
        </div>
        <div class="vr"></div>
        <div id="perfil-caracterização-texto">
            <ul>
                <li><strong>Nome de Utilizador:</strong> {{ $usr->nome_utilizador }}</li>
                <li><strong>E-Mail: </strong> {{ $usr->e_mail }}</li>
                <li><strong>Data de nascimento: </strong> {{ \Carbon\Carbon::parse($usr->data_nascimento)->format('d/m/Y') }}</li>
            </ul>
            @if (!is_null($usr->descricao))
                <hr>
                <article>{{ $usr->descricao }}</article>
            @endif
        </div>
    </div>
    @if ($usr->ativo->questoes->count() || $usr->ativo->etiquetasSeguidas->count())
        <hr>
        <div id="perfil-listagens">
            @if ($usr->ativo->questoes->count())
                @include('partials.lista-perfil', [
                    'titulo' => 'As minhas questões',
                    'colecao' => $colecaoQuestoes,
                    'total' => $totalQuestoes
                ])
            @endif
            @if ($usr->ativo->etiquetasSeguidas->count())
                @include('partials.lista-perfil', [
                    'titulo' => 'Etiquetas seguidas',
                    'colecao' => $colecaoEtiquetas,
                    'total' =>  $totalEtiquetas
                ])
            @endif
        </div>
    @endif
</div>
@endsection