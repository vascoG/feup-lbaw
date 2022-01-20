@extends('layouts.admin-dashboard', [
    'selecionado' => 'ban'
])

@section('titulo')
Administração de apelos 
@endsection


@section('conteudo') 
<div class="d-flex flex-wrap justify-content-start mt-4"> 
        @each('partials.cards.admin.apelo', $apelos, 'apelo')
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
    
@endsection