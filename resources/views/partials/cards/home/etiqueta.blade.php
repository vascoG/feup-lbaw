<article class="homepage-etiqueta-card">
    <p>{{ $etiqueta->nome }}</p>
    @auth
        <div>
            <button id="admin-etiqueta-elimina" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#admin-elimina-etiqueta-modal" data-bs-id="{{ $etiqueta->id }}" data-bs-nome="{{ $etiqueta->nome }}">Eliminar</button>
            <button id="admin-etiqueta-edita" type="button" class="btn btn-primary admin-edita-etiqueta-btn" data-bs-toggle="modal" data-bs-target="#admin-edita-etiqueta-modal" data-bs-id="{{ $etiqueta->id }}" data-bs-nome="{{ $etiqueta->nome }}">Editar</button>
        </div>
    @endauth
</article>