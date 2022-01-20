@extends('layouts.minimo')

@section('titulo')
Apelos de {{ $nomeUtilizador }}
@endsection

@section('conteudo')
<div class="mx-3 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3>A aguardar análise...</h3>
    </div>
    <div class="w-75 m-auto d-flex flex-column justify-content-start mt-3">
        @each('partials.cards.apelo', $apelos, 'apelo')
    </div>
</div>
@endsection