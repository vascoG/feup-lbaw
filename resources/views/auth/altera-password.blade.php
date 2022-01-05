@extends('layouts.minimo')

@section('titulo')
Alteração de Password
@endsection

@section('conteudo')
<div class="form-recuperacao">
    <form method="POST" action="{{ route('altera-password', $token) }}">
        @csrf

        <div class="form-group campo-form-autenticacao">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="e_mail" value="{{ old('e_mail') }}" class="form-control" required autofocus>
        </div>
        @if ($errors->has('e_mail'))
            <span class="erro-input">
            {{ $errors->first('e_mail') }}
            </span>
        @endif
        <div class="form-group campo-form-autenticacao">
            <label for="palavra_passe" class="form-label">Palavra-passe</label>
            <input id="palavra_passe" class="form-control" type="password" name="password" required>
            @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
            @endif
        </div>
    
        <div class="form-group campo-form-autenticacao">
            <label for="palavra-passe-confirmacao" class="form-label">Confirmação da palavra-passe</label>
            <input id="palavra-passe-confirmacao" class="form-control" type="password" name="password_confirmation" required>
        </div>
        <input type="text" class="d-none" name="token" value={{ $token }} required>

        <div class="campo-form-autenticacao" id="botoes-login">
            <button type="submit" class="btn btn-primary px-4 btn-primary">Submeter</button>
        </div>
    </form>
</div>
@endsection