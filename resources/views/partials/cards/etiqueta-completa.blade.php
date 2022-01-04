<article class="d-flex flex-column flex-nowrap etiqueta-card" data-id={{ $etiqueta->id }}>
    <p class="flex-grow-1">{{ $etiqueta->nome }}</p>
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
</article>