@extends('layouts.minimo')

@section('titulo')
Etiquetas de {{ $nomeUtilizador }}
@endsection

@push('scripts')
    <script src="{{ asset('js/clicavel.js') }}"></script>
@endpush

@section('conteudo')
<div class="mx-3 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Etiquetas de {{ $nomeUtilizador }}</h3>
        <a class="btn btn-primary" href="{{ url()->previous() }}">Voltar para a página anterior</a>
    </div>
    <div class="d-flex flex-row flex-wrap justify-content-start mt-3">
        @each('partials.cards.etiqueta', $etiquetas, 'etiqueta')
    </div>
</div>
@endsection