@extends('layouts.geral')

@push('scripts')
    <script src={{ asset('js/lista-questoes.js') }}></script>
@endpush

@section('conteudo')
@include('partials.questoes-filtro.pesquisa-filtro')
<div id="conteudo-lista-questoes">
    @if ($questoes->isEmpty())
        <h1>Não foram encontradas questões que respeitassem os filtros de pesquisa</h1>
    @else
        @foreach ($questoes as $questao)
            @include('partials.cards.questao', [
                'questao' => $questao,
                'autor' => $questao->criador->utilizador
            ])
        @endforeach
    @endif
</div>
@endsection