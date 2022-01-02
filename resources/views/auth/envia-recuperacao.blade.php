@extends('layouts.minimo')

@section('conteudo')
<div class="form-recuperacao">
    <form method="POST" action="{{ route('recupera-password') }}">
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
        <div class="campo-form-autenticacao" id="botoes-login">
            <a class="btn btn-secondary px-2 autenticacao-secundario" href="{{ url()->previous() }}">Voltar</a>
            <button type="submit" class="btn btn-primary px-4 btn-primary">Submeter</button>
        </div>
    </form>
</div>
@endsection