@extends('layouts.minimo')

@section('titulo')
Recuperar Conta
@endsection

@section('conteudo')
<div class="form-recuperacao">
    <form method="POST" action="{{ route('recupera-password') }}">
        @csrf
        <div class="campo-form-autenticacao">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="e_mail" value="{{ old('e_mail') }}" class="form-control {{ $errors->has('e_mail') ? "is-invalid" : (session('status') ? "is-valid" : "") }}" required autofocus>
            @if ($errors->has('e_mail'))
                <div class="invalid-feedback d-block">
                    {{ $errors->first('e_mail') }}
                </div>
            @elseif (session('status'))
                <div class="valid-feedback d-block">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="campo-form-autenticacao" id="botoes-login">
            <a class="btn btn-secondary px-2 autenticacao-secundario" href="{{ url()->previous() }}">Voltar</a>
            <button type="submit" class="btn btn-primary px-4 btn-primary">Submeter</button>
        </div>
    </form>
</div>
@endsection