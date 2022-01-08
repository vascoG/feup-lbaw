@extends('layouts.minimo')

@section('titulo')
Login
@endsection

@section('conteudo')
<div class="d-flex justify-content-center pt-4">
    <form method="POST" action="{{ route('login') }}" class="form-autenticacao">
        @csrf

        <div class="campo-form-autenticacao">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="e_mail" value="{{ old('e_mail') }}" class="form-control {{ $errors->has('password') || $errors->has('e_mail') ? "is-invalid" : "" }}" required autofocus>
        </div>
        
        <div class="campo-form-autenticacao">
            <label for="palavra-passe" class="form-label">Palavra-passe</label>
            <input id="palavra-passe" type="password" name="password" class="form-control {{ $errors->has('password') || $errors->has('e_mail') ? "is-invalid" : "" }}" required>
        </div>
        
        @if ($errors->has('e_mail'))
            <div class="invalid-feedback d-block campo-form-autenticacao">
                {{ $errors->first('e_mail') }}
            </div>
        @endif
        @if ($errors->first('password'))
            <div class="invalid-feedback d-block campo-form-autenticacao">
                {{ $errors->first('password') }}
            </div>
        @endif

        <div class="form-check campo-form-autenticacao">
            <label for="login-lembrar" class="form-check-label">Lembrar-me</label>
            <input type="checkbox" name="remember" id="login-lembrar" class="form-check-input shadow-none cb-cor-diferente" {{ old('remember') ? 'checked' : '' }}>
        </div>

        <div class="d-flex align-items-end justify-content-between campo-form-autenticacao">
            <a class="text-danger" href="{{ route('recupera-password') }}">Esqueci-me da palavra-passe</a>
            <div id="botoes-login">
                <a class="btn btn-secondary px-2 autenticacao-secundario" href="{{ route('registo') }}">Registe-se</a>
                <button type="submit" class="btn btn-primary px-4 btn-primary">Login</button>
            </div>
        </div>
    </form>
</div>
@endsection
