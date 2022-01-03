@extends('layouts.admin-dashboard', [
    'selecionado' => 'etiquetas'
])

@push('scripts')
    <script src="{{ asset('js/admin-etiquetas.js') }}"></script>
@endpush

@section('conteudo')
    <div id="admin-etiquetas">
      <div class="modal fade" id="admin-cria-etiqueta-modal" tabindex="-1" aria-labelledby="admin-cria-etiqueta-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="admin-cria-etiqueta-modal-label">Criar etiqueta</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text" id="admin-cria-etiqueta-text" class="form-control" placeholder="Escreva aqui o nome da etiqueta">
              <div id="admin-cria-etiqueta-text-feedback" class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="admin-etiqueta-cria-btn" class="btn btn-primary admin-etiqueta-submete-acao">Criar</button>
              <button type="button" class="btn btn-primary admin-etiqueta-loading-acao" disabled>
                <span class="spinner-border spinner-border-sm" role="status"></span>
                <span>A criar...</span>
              </button>
            </div>
          </div>
        </div>
      </div>
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
              <button type="button" id="admin-etiqueta-apaga-btn" class="btn btn-danger admin-etiqueta-submete-acao">Eliminar</button>
              <button type="button" class="btn btn-danger admin-etiqueta-loading-acao" disabled>
                <span class="spinner-border spinner-border-sm" role="status"></span>
                <span>A eliminar...</span>
              </button>
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
              <button type="button" id="admin-etiqueta-edita-guarda" class="btn btn-primary admin-etiqueta-submete-acao">Guardar</button>
              <button type="button" class="btn btn-primary admin-etiqueta-loading-acao" disabled>
                <span class="spinner-border spinner-border-sm" role="status"></span>
                <span>A guardar...</span>
              </button>
            </div>
          </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#admin-cria-etiqueta-modal">
          <i class="bi bi-plus-square"></i>
          Criar etiqueta
        </button>
        @include('partials.barra-pesquisa', [
            'acaoPesquisa' => route('etiquetas'),
            'query' => $query,
            'placeholder' => 'Nome da etiqueta...'
        ])
    </div>
    <div class="d-flex justify-content-around flex-wrap mt-4">
        @each('pages.admin.etiqueta', $etiquetas, 'etiqueta')
    </div>
    <div id="admin-etiqueta-conexao-erro" class="toast position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-warning text-dark">
        <strong class="me-auto">Ocorreu um erro ao submeter as alterações</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Verifique a sua ligação com a internet e tente novamente. 
      </div>
    </div>
</div>
@endsection