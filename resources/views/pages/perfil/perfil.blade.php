@extends('layouts.geral')

@push('scripts')
    <script src="{{ asset('js/perfil.js') }}"></script>
@endpush

@section('titulo')
Perfil de {{ $usr->nome_utilizador }}
@endsection

@section('conteudo')
<div id="corpo-perfil">
    <h1 id="perfil-nome-utilizador">{{ $usr->nome }}</h1>
    <div id="perfil-caracterizacao">
        <div id="perfil-avatar-container">
            <img id="perfil-avatar" src="{{ asset($usr->imagem_perfil) }}" alt="Imagem de perfil">
        </div>
        <div class="vr"></div>
        <div id="perfil-caracterização-texto">
            <div class="d-flex">
                <ul class="flex-grow-1">
                    <li><strong>Nome de Utilizador:</strong> {{ $usr->nome_utilizador }}</li>
                    <li><strong>E-Mail: </strong> {{ $usr->e_mail }}</li>
                    <li><strong>Data de nascimento: </strong> {{ \Carbon\Carbon::parse($usr->data_nascimento)->format('d/m/Y') }}</li>
                </ul>
                @can('editar', $usr)
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-dark" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('editar-perfil', $usr->nome_utilizador) }}">Editar</a>
                            <a id="perfil-apagar" class="dropdown-item text-danger" data-nome-utilizador="{{ $usr->nome_utilizador }}" href="{{ route('perfil', $usr->nome_utilizador) }}">Apagar</a>
                        </div>
                    </div>
                @endcan
            </div>
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