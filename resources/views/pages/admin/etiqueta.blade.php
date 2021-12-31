<article class="admin-etiqueta-card">
    <p>{{ $etiqueta->nome }}</p>
    <div>
        <button id="admin-etiqueta-elimina" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#admin-backdrop-etiqueta-{{ $etiqueta->id }}">Eliminar</button>
        <button id="admin-etiqueta-edita" data-id={{ $etiqueta->id }} type="button" class="btn btn-primary admin-edita-etiqueta-btn">Editar</button>
    </div>
</article>

<!-- Modal -->
<div class="modal fade" id="admin-backdrop-etiqueta-{{ $etiqueta->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="admin-backdrop-label-etiqueta-{{ $etiqueta->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="admin-backdrop-label-etiqueta-{{ $etiqueta->id }}">Eliminação de etiqueta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Tem a certeza que quer apagar a etiqueta de nome: {{ $etiqueta->nome }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger admin-elimina-etiqueta-btn" data-id={{ $etiqueta->id }}>Eliminar</button>
        </div>
      </div>
    </div>
</div>
