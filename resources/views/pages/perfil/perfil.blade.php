@extends('layouts.geral')

@section('conteudo')
<div id="corpo-perfil">
    <div>
        <h1 id="perfil-nome-utilizador"><strong>{{ $usr->nome }}</strong>({{ $usr->nome_utilizador }})</h1>
    </div>
    <div id="perfil-caracterizacao">
        <div id="perfil-avatar-container">
            <img id="perfil-avatar" src="{{ asset($usr->imagem_perfil) }}">
        </div>
        <div class="vr"></div>
        <div id="perfil-caracterização-texto">
            <ul>
                <li><strong>E-Mail:</strong> {{ $usr->e_mail }}</li>
                <li><strong>Data de nascimento:</strong> {{ \Carbon\Carbon::parse($usr->data_nascimento)->format('d/m/Y') }}</li>
            </ul>
            @if (!is_null($usr->descricao))
                <hr>
                <article>{{ $usr->descricao }}</article>
            @endif
        </div>
    </div>
    @include('partials.perfil-questoes', ['usr' => $usr->ativo])
</div>
@endsection