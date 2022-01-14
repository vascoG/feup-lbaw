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
@endsection