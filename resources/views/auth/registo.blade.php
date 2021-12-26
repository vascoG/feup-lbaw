@extends('layouts.minimo')

@section('conteudo')
<div class="d-flex justify-content-center pt-4">
  <form id="login-form" class="form-autenticacao" method="POST" action="{{ route('registo') }}">
    {{ csrf_field() }}

    <div class="form-group campo-form-autenticacao">
      <label for="nome-utilizador" class="form-label">Nome de utilizador</label>
      <input id="nome-utilizador" class="form-control" type="text" name="nome_utilizador" value="{{ old('nome_utilizador') }}" required autofocus>
      @if ($errors->has('nome_utilizador'))
        <span class="error">
            {{ $errors->first('nome_utilizador') }}
        </span>
      @endif
    </div>

    <div class="form-group campo-form-autenticacao">
      <label for="nome" class="form-label">Nome de apresentação</label>
      <input id="nome" class="form-control" type="text" name="nome" value="{{ old('nome') }}" required autofocus>
      @if ($errors->has('nome'))
        <span class="error">
            {{ $errors->first('nome') }}
        </span>
      @endif
    </div>

    <div class="form-group campo-form-autenticacao">
      <label for="email" class="form-label">Endereço de E-Mail</label>
      <input id="email" class="form-control" type="email" name="e_mail" value="{{ old('e_mail') }}" required>
      @if ($errors->has('e_mail'))
        <span class="error">
            {{ $errors->first('e_mail') }}
        </span>
      @endif
    </div>

    <div class="form-group campo-form-autenticacao">
      <label for="data-nascimento" class="form-label">Data de nascimento</label>
      <input id="data-nascimento" class="form-control" type="date" name="data_nascimento" value="{{ old('data_nascimento') }}"required>
      @if ($errors->has('data_nascimento'))
        <span class="error">
          {{ $errors->first('data_nascimento') }}
        </span>
      @endif
    </div>

    <div class="form-group campo-form-autenticacao">
      <label for="palavra_passe" class="form-label">Palavra-passe</label>
      <input id="palavra_passe" class="form-control" type="password" name="palavra_passe" required>
      @if ($errors->has('palavra_passe'))
        <span class="error">
            {{ $errors->first('palavra_passe') }}
        </span>
      @endif
    </div>

    <div class="form-group campo-form-autenticacao">
      <label for="palavra-passe-confirmacao" class="form-label">Confirmação da palavra-passe</label>
      <input id="palavra-passe-confirmacao" class="form-control" type="password" name="palavra_passe_confirmation" required>
    </div>

    <div class="campo-form-autenticacao" id="botoes-login">
      <a class="btn btn-secondary px-4 autenticacao-secundario" href="{{ route('login') }}">Login</a>
      <button type="submit" class="btn btn-primary px-2 autenticacao-primario">Registar</button>
    </div>
  </form>
</div>
@endsection
