@extends('layouts.minimo')

@section('conteudo')
<div class="d-flex justify-content-center pt-4">
    <form method="POST" action="{{ route('login') }}" class="form-autenticacao">
        {{ csrf_field() }}

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
            <label for="palavra-passe" class="form-label">Palavra-passe</label>
            <input id="palavra-passe" type="password" name="password" class="form-control" required>
            @if ($errors->has('password'))
                <span class="erro-input">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="form-check campo-form-autenticacao">
            <label for="login-lembrar" class="form-check-label">Lembrar-me</label>
            <input type="checkbox" name="remember" id="login-lembrar" class="form-check-input shadow-none cb-cor-diferente" {{ old('remember') ? 'checked' : '' }}>
        </div>

        <div class="campo-form-autenticacao" id="botoes-login">
            <a class="btn btn-secondary px-2 autenticacao-secundario" href="{{ route('registo') }}">Registe-se</a>
            <button type="submit" class="btn btn-primary px-4 autenticacao-primario">Login</button>
        </div>
    </form>
</div>
@endsection
