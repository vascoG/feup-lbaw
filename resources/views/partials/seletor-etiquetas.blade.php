@once
    @push('scripts')
        <script src="{{ asset('js/seletor-etiquetas.js') }}"></script>
    @endpush
@endonce

<h5>Etiquetas</h5>
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
                    <input class="form-check-input" type="checkbox" name="etiqueta" value="{{ $etiqueta->id }}" disabled {{ in_array($etiqueta->id, $etiquetas) ? "checked" : "" }}>
                </div>
            </li>
        @endforeach
    </ul>
    <input id="etiqueta-secreta" class="d-none" name="etiqueta" {{ count($etiquetas) ? strtr('value=@etiquetas', ['@etiquetas' => implode(',', $etiquetas)]) : "" }} type="hidden">
</div>