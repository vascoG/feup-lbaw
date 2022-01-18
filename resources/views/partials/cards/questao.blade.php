<article class="card card-questao p-2 my-3 clicavel" data-href={{ route('questao', $questao->id) }}>
    <div class="card-body card-questao-body">
        <h1 class="card-title">{{ $questao->titulo }}</h1>
        <hr>
        <p class="card-text">{{ $questao->texto }}</p>
    </div>
    <div class="d-flex justify-content-end card-questao-etiquetas gap-3 mb-2 mt-3">
        @foreach ($questao->etiquetas->slice(0, 4) as $etiqueta)
            @include('partials.cards.pill-etiqueta', [
                'etiqueta' => $etiqueta
            ])
        @endforeach
    </div>
    <div class="d-flex card-questao-dados">
        @if ($questao->criador)
            <a class="card-questao-usr-link" href="{{ route('perfil', $questao->criador->utilizador->nome_utilizador) }}">
                {{ $questao->criador->utilizador->nome_utilizador }}
            </a>
        @else
            <p>{{ App\Models\Utilizador::$nomePadrao }}</p>
        @endif
        <div class="vr mx-1"></div>
        <p>{{ $questao->data_publicacao->setTimezone('Europe/Lisbon')->format('d/m/Y H:i') }}</p>
    </div>
</article>