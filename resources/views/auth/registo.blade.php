@extends('layouts.minimo')

@push('scripts')
  <script src="{{ asset('js/tooltip.js') }}"></script>
@endpush

@section('titulo')
Registar
@endsection

@section('conteudo')
<div class="d-flex justify-content-center pt-4">
  <form id="login-form" class="form-autenticacao" method="POST" action="{{ route('registo') }}">
    @csrf

    <div class="campo-form-autenticacao">
      <label for="nome-utilizador" class="form-label">Nome de utilizador</label>
      <input id="nome-utilizador" class="ajuda form-control {{ $errors->has('nome_utilizador') ? "is-invalid" : "" }}" type="text" name="nome_utilizador" value="{{ old('nome_utilizador') }}" required autofocus data-bs-toggle="tooltip" data-bs-placement="right" title="Pode conter letras ou números. Como separador utilizar '-'">
      @if ($errors->has('nome_utilizador'))
        <div class="invalid-feedback d-block">
          {{ $errors->first('nome_utilizador') }}
        </div>
      @endif
    </div>

    <div class="campo-form-autenticacao">
      <label for="nome" class="form-label">Nome de apresentação</label>
      <input id="nome" class="form-control {{ $errors->has('nome') ? "is-invalid" : "" }}" type="text" name="nome" value="{{ old('nome') }}" required autofocus>
      @if ($errors->has('nome'))
        <div class="invalid-feedback d-block">
          {{ $errors->first('nome') }}
        </div>
      @endif
    </div>

    <div class="campo-form-autenticacao">
      <label for="email" class="form-label">Endereço de E-Mail</label>
      <input id="email" class="form-control {{ $errors->has('e_mail') ? "is-invalid" : "" }}" type="email" name="e_mail" value="{{ old('e_mail') }}" required>
      @if ($errors->has('e_mail'))
        <div class="invalid-feedback d-block">
          {{ $errors->first('e_mail') }}
        </div>
      @endif
    </div>

    <div class="campo-form-autenticacao">
      <label for="data-nascimento" class="form-label">Data de nascimento</label>
      <input id="data-nascimento" class="form-control {{ $errors->has('data_nascimento') ? "is-invalid" : "" }}" type="date" name="data_nascimento" value="{{ old('data_nascimento') }}"required>
      @if ($errors->has('data_nascimento'))
        <div class="invalid-feedback d-block">
          {{ $errors->first('data_nascimento') }}
        </div>
      @endif
    </div>

    <div class="campo-form-autenticacao">
      <label for="palavra_passe" class="form-label">Palavra-passe</label>
      <input id="palavra_passe" class="ajuda form-control {{ $errors->has('palavra_passe') ? "is-invalid" : "" }}" type="password" name="palavra_passe" required data-bs-toggle="tooltip" data-bs-placement="right" title="Deve ter pelo menos 8 caracteres">
    </div>

    <div class="campo-form-autenticacao">
      <label for="palavra-passe-confirmacao" class="form-label">Confirmação da palavra-passe</label>
      <input id="palavra-passe-confirmacao" class="form-control {{ $errors->has('palavra_passe') ? "is-invalid" : "" }}" type="password" name="palavra_passe_confirmation" required>
      @if ($errors->has('palavra_passe'))
        <div class="invalid-feedback d-block">
          {{ $errors->first('palavra_passe') }}
        </div>
      @endif
    </div>

    <div class="campo-form-autenticacao" id="botoes-login">
      <a class="btn btn-secondary px-4 autenticacao-secundario" href="{{ route('login') }}">Login</a>
      <button type="submit" class="btn btn-primary px-2 btn-primary">Registar</button>
    </div>
  </form>
</div>
@endsection
