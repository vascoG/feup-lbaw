@extends('layouts.homepage')

@push('scripts')
    <script src={{ asset('js/lista-questoes.js') }}></script>
@endpush

@section('titulo')
Tendencias
@endsection

@section('barra-pesquisa')
    @include('partials.barra-pesquisa', [
        'acaoPesquisa' => route('pesquisa'),
        'placeholder' => 'Procurar questões...'
    ])
@endsection

@section('homepage-conteudo')
    @each('partials.cards.questao', $questoes, 'questao')
@endsection