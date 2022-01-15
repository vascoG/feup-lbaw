@extends('layouts.minimo')

@push('scripts')
    <script src={{ asset('js/clicavel.js') }}></script>
@endpush

@section('titulo')
Respostas de {{ $nomeUtilizador }}
@endsection

@section('conteudo')
<div class="mx-3 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Questões respondidas por {{ $nomeUtilizador }}</h3>
        <a class="btn btn-primary" href="{{ url()->previous() }}">Voltar para a página anterior</a>
    </div>
    <div class="w-75 m-auto d-flex flex-column justify-content-start mt-3">
        @each('partials.cards.questao', $questoes, 'questao')
    </div>
</div>
@endsection