<div class="pt-4">
    <form method="GET" action={{ route('pesquisa') }}>
        <div id="pesquisa-query" class="input-group">
            <input class="form-control" name="query" value="{{ $query }}" placeholder="Procurar questões...">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-avancados" aria-expanded="false" aria-controls="filtros-avancados">
                <i class="bi bi-funnel"></i>
            </button>
            <button id="botao-pesquisa" class="btn btn-outline-secondary submete-etiquetas" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="collapse" id="filtros-avancados">
            <div class="d-flex">
                <div id="pesquisa-contentor-etiquetas" class="pesquisa-avancada-item">
                    @include('partials.seletor-etiquetas')
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
    </form>
</div>