@extends('layouts.minimo')

@section('conteudo')
    <form method="POST" action="{{ route('login') }}" id="login-form">
        {{ csrf_field() }}
    
        <div class="form-group login-field">
            <label for="e_mail" class="form-label">Email</label>
            <input id="e_mail" type="email" name="e_mail" value="{{ old('e_mail') }}" class="form-control" required autofocus>
        </div>
        @if ($errors->has('e_mail'))
            <span class="erro-input">
            {{ $errors->first('e_mail') }}
            </span>
        @endif
        
        <div class="form-group login-field">
            <label for="palavra_passe" class="form-label">Palavra-passe</label>
            <input id="palavra_passe" type="password" name="palavra_passe" class="form-control" required>
            @if ($errors->has('palavra_passe'))
                <span class="erro-input">
                    {{ $errors->first('palavra_passe') }}
                </span>
            @endif
        </div>
    
        <div class="form-check login-field">
            <label for="login-lembrar" class="form-check-label">Lembrar-me</label>
            <input type="checkbox" name="lembrar" id="login-lembrar" class="form-check-input shadow-none" {{ old('lembrar') ? 'checked' : '' }}>
        </div>
    
        <div class="login-field" id="botoes-login">
            <a id="login-registo" class="btn btn-secondary px-2" href="{{ route('registo') }}">Registe-se</a>
            <button type="submit" id="login-submeter" class="btn btn-primary px-4">Login</button>
        </div>
    </form>
@endsection
