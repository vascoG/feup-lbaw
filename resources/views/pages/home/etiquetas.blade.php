@extends('layouts.homepage')

@push('scripts')
    <script src="{{ asset('js/etiqueta-homepage.js') }}"></script>
@endpush

@section('titulo')
Etiquetas na Homepage
@endsection

@section('barra-pesquisa')
    @include('partials.barra-pesquisa', [
        'acaoPesquisa' => route('homepage-etiquetas'),
        'placeholder' => 'Procurar etiquetas...'
    ])
@endsection

@section('homepage-conteudo')
    <div class="d-flex flex-wrap justify-content-start gap-3 ps-4">
        @each('partials.cards.etiqueta-completa', $etiquetas, 'etiqueta')
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