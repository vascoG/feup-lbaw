@extends('layouts.admin-dashboard', [
    'selecionado' => 'moderadores'
])

@push('scripts')
    <script src="{{ asset('js/admin-moderadores.js') }}"></script>
@endpush

@section('titulo')
Administração de moderadores
@endsection


@section('conteudo') 

<div class="d-flex flex-wrap justify-content-start gap-3 ps-4">
        @each('partials.moderador-completo', $users, 'users')
    </div>
    <div id="homepage-etiqueta-conexao-erro" class="toast position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-dark">
          <strong class="me-auto">Ocorreu um erro ao submeter as alterações</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Verifique a sua ligação com a internet e tente novamente. 
        </div>
    </div>
    <div class="d-flex justify-content-center my-3">
    {{ $users->links() }}
</div>
@endsection