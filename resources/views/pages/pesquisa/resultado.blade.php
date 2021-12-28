@extends('layouts.geral')

@push('scripts')
    <script src={{ asset('js/lista-questoes.js') }}></script>
@endpush

@section('conteudo')
<div id="conteudo-lista-questoes">
    @foreach ($questoes as $questao)
        @include('partials.cards.questao', [
            'questao' => $questao,
            'autor' => $questao->criador->utilizador
        ])
    @endforeach
</div>
@endsection