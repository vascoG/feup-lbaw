@extends('partials.cards.etiqueta')

@section('controlos')
    @auth
    <div class="d-flex flex-row flex-nowrap">
        @if (Auth::user()->ativo->segueEtiqueta($etiqueta))
            <button type="button" class="flex-grow-1 btn btn-primary homepage-etiqueta-acao" data-id="{{ $etiqueta->id }}">Parar de seguir</button>
        @else
            <button type="button" class="flex-grow-1 btn btn-primary homepage-etiqueta-acao" data-id="{{ $etiqueta->id }}">Seguir</button>
        @endif
        <button type="button" class="flex-grow-1 btn btn-primary homepage-etiqueta-acao-espera" data-id="{{ $etiqueta->id }}" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            A processar
        </button>
    </div>
    @endauth
@endsection