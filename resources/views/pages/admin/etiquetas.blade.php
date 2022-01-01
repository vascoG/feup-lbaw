@extends('layouts.admin-dashboard', [
    'selecionado' => 'etiquetas'
])

@push('scripts')
    <script src="{{ asset('js/admin-etiquetas.js') }}"></script>
@endpush

@section('conteudo')
<div id="admin-etiquetas">
    <div class="d-flex justify-content-end">
        @include('partials.barra-pesquisa', [
            'acaoPesquisa' => route('etiquetas'),
            'query' => $query,
            'placeholder' => 'Nome da etiqueta...'
        ])
    </div>
    <div>
        @each('pages.admin.etiqueta', $etiquetas, 'etiqueta')
        <div class="modal fade" id="admin-elimina-etiqueta-modal" tabindex="-1" aria-labelledby="admin-elimina-etiqueta-modal-label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="admin-elimina-etiqueta-modal-label">Eliminar etiqueta</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="admin-etiqueta-apaga-txt"></div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" id="admin-etiqueta-apaga-btn" class="btn btn-danger">Eliminar</button>
                </div>
              </div>
            </div>
        </div>
          
        <div class="modal fade" id="admin-edita-etiqueta-modal" tabindex="-1" aria-labelledby="admin-edita-etiqueta-modal-label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="admin-edita-etiqueta-modal-label">Editar etiqueta</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <input type="text" id="admin-etiqueta-text" class="form-control" placeholder="Escreva aqui o nome da etiqueta">
                  <div id="admin-etiqueta-text-feedback" class="invalid-feedback"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" id="admin-etiqueta-edita-guarda" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection