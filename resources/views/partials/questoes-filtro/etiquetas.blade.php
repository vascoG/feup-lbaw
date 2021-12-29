<div class="input-group">
    <div id="mostrador-etiquetas" class="form-control"></div>
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
    <ul id="lista-etiquetas" class="dropdown-menu dropdown-menu-end">
        <input id="filtro-etiquetas" type="text" class="form-control" autocomplete="off">
        <li><hr class="dropdown-divider"></li>
        @foreach (\App\Models\Etiqueta::all() as $etiqueta)
            <li class="pesquisa-etiqueta">
                <div class="d-flex justify-content-between dropdown-item cm-ativa-checkbox">
                    <p class="nao-selecionavel">{{ $etiqueta->nome }}</p>
                    <input class="form-check-input" type="checkbox" name="etiqueta" value="{{ $etiqueta->id }}" readonly="readonly">
                </div>
            </li>
        @endforeach
    </ul>
</div>