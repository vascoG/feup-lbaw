@extends('partials.moderador')

@section('controlos')
    <div class="d-flex flex-row flex-nowrap">
        @if ($users->moderador)
            <button type="button" class="flex-grow-1 btn btn-primary admin-moderador-acao" data-id="{{ $users->id_utilizador }}">Remover Moderador</button>
        @else
            <button type="button" class="flex-grow-1 btn btn-primary admin-moderador-acao" data-id="{{$users->id_utilizador}}">Adicionar Moderador</button>
        @endif
        <button type="button" class="flex-grow-1 btn btn-primary admin-moderador-acao-espera" data-id="{{ $users->id_utilizador }}" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            A processar
        </button>
    </div>
@endsection
