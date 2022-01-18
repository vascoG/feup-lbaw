@extends('layouts.geral')

@push('scripts')
    <script src={{ asset('js/clicavel.js') }}></script>
@endpush

@section('titulo')
    @if ($query)
        {{ $query }}
    @else
        Pesquisa de questões
    @endif
@endsection

@section('conteudo')
@include('partials.pesquisa-filtro', [
    'ordenarAtributo' => $ordenarAtributo,
    'ordenarOrdem' => $ordenarOrdem,
    'query' => $query,
    'etiquetas' => $etiquetas,
])
<div id="conteudo-lista-questoes">
    @if ($questoes->isEmpty())
        <h4 class="text-center mt-5">Não foram encontradas questões que respeitassem os filtros de pesquisa</h4>
    @else
        @foreach ($questoes as $questao)
            @include('partials.cards.questao', [
                'questao' => $questao,
            ])
        @endforeach
    @endif
</div>
<div class="d-flex justify-content-center my-3">
    {{ $questoes->links() }}
</div>
@endsection