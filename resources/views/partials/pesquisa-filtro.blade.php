@push('scripts')
    <script src="{{ asset('js/filtro-pesquisa.js') }}"></script>
@endpush

<div class="pt-4">
    <form method="GET" action={{ route('pesquisa') }}>
        <div id="pesquisa-query" class="input-group">
            <input class="form-control" name="query" value="{{ $query }}" placeholder="Procurar questões...">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-avancados" aria-expanded="false" aria-controls="filtros-avancados">
                <i class="bi bi-funnel"></i>
            </button>
            <button id="botao-pesquisa" class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="collapse" id="filtros-avancados">
            <div class="d-flex">
                <div id="pesquisa-contentor-etiquetas" class="pesquisa-avancada-item">
                    <h5 class="pesquisa-header-filtro">Etiquetas</h5>
                    <div class="input-group">
                        <div id="mostrador-etiquetas" class="form-control"></div>
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul id="lista-etiquetas" class="dropdown-menu dropdown-menu-end">
                            <li><input id="filtro-etiquetas" type="text" class="form-control" autocomplete="off"></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach (\App\Models\Etiqueta::all() as $etiqueta)
                                <li class="pesquisa-etiqueta">
                                    <div class="d-flex justify-content-between dropdown-item cm-ativa-checkbox" id={{ "filtro-etiqueta-".$etiqueta->id }}>
                                        <p class="nao-selecionavel">{{ $etiqueta->nome }}</p>
                                        <input class="form-check-input" type="checkbox" value="{{ $etiqueta->id }}" disabled {{ in_array($etiqueta->id, $etiquetas) ? "checked" : "" }}>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="vr"></div>
                <div id="pesquisa-ordem-atributo" class="pesquisa-avancada-item">
                    <h5>Critério de pesquisa</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordenar-atributo" value="mais-recentes" id="mais-recentes" checked>
                        <label class="form-check-label" for="mais-recentes">Mais Recentes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordenar-atributo" value="mais-votos" id="mais-votos" {{ ($ordenarAtributo == 'mais-votos' ? "checked" : "") }}>
                        <label class="form-check-label" for="mais-votos">Mais Votos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordenar-atributo" value="mais-reputacao" id="mais-reputacao" {{ ($ordenarAtributo == 'mais-reputacao' ? "checked" : "") }}>
                        <label class="form-check-label" for="mais-reputacao">Mais Reputação</label>
                    </div>
                </div>
                <div class="vr"></div>
                <div id="pesquisa-ordem" class="pesquisa-avancada-item">
                    <h5>Critério de ordenação</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordenar-ordem" value="desc" id="decres" checked>
                        <label class="form-check-label" for="decres">Decrescente</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordenar-ordem" value="asc" id="cres" {{ $ordenarOrdem == "asc" ? "checked" : "" }}>
                        <label class="form-check-label" for="cres">Crescente</label>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <input id="etiqueta-secreta" class="d-none" name="etiqueta" {{ count($etiquetas) ? strtr('value=@etiquetas', ['@etiquetas' => implode(',', $etiquetas)]) : "" }} type="hidden">
    </form>
</div>