@extends('layouts.minimo')

@push('scripts')
    <script src="{{ asset('js/editar-perfil.js') }}"></script>
@endpush

@section('conteudo')
<form method="POST" action="{{ route('editar-perfil-imagem', $nomeUtilizador) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-center">
        <img id="edita-perfil-imagem" data-nome-utilizador="{{ $nomeUtilizador }}" src="{{ asset($imagem_perfil) }}" alt="Imagem de perfil do utilizador">
        <div class="d-flex flex-column justify-content-center">
            <input type="file" class="form-control" name="imagem_perfil">
            <div class="d-inline-flex flex-row justify-content-between mt-2">
                <button type="button" id="editar-perfil-apaga-imagem" class="btn btn-danger px-5">Apagar</button>
                <button type="submit" class="btn btn-primary px-5">Enviar</button>
            </div>
        </div>
    </div>
</form>

<form id="edita-perfil-texto" method="POST" action="{{ route('perfil', $nomeUtilizador) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="nome" class="form-label">Nome</label>
        <input id="nome" class="form-control" type="text" name="nome" value="{{ is_null(old('nome')) ? $nome : old('nome') }}">
        @if ($errors->has('nome'))
            <span class="error">
                {{ $errors->first('nome') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input id="email" class="form-control" type="email" name="e_mail" value="{{ is_null(old('e_mail')) ? $email : old('e_mail') }}">
        @if ($errors->has('e_mail'))
            <span class="error">
                {{ $errors->first('e_mail') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="data_nascimento" class="form-label">Data de nascimento</label>
        <input id="data_nascimento" class="form-control" type="date" name="data_nascimento" value="{{ is_null(old('data_nascimento')) ? \Carbon\Carbon::parse($dataNascimento)->format('Y-m-d') : old('data_nascimento') }}">
        @if ($errors->has('data_nascimento'))
            <span class="error">
                {{ $errors->first('data_nascimento') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" class="form-control" maxlength="{{ $descricaoTamanhoMax }}" name="descricao" rows="5">{{ is_null(old('descricao')) ? $descricao : old('descricao') }}</textarea>
        <span id="desc-char-cnt"></span>
    </div>

    <div class="form-group">
        <label for="palavra_passe" class="form-label">Palavra-passe</label>
        <input id="palavra_passe" class="form-control" type="password" name="palavra_passe">
        @if ($errors->has('palavra_passe'))
        <span class="error">
            {{ $errors->first('palavra_passe') }}
        </span>
        @endif
    </div>

    <div class="form-group">
        <label for="palavra-passe-confirmacao" class="form-label">Confirmação da palavra-passe</label>
        <input id="palavra-passe-confirmacao" class="form-control" type="password" name="palavra_passe_confirmation">
    </div>

    <div class="campo-form-autenticacao" id="botoes-login">
        <a class="btn btn-secondary px-4 autenticacao-secundario" href="{{ route('perfil', $nomeUtilizador) }}">Voltar</a>
        <button type="submit" class="btn btn-primary px-2 autenticacao-primario">Guardar</button>
    </div>
</form>
@endsection