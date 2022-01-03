@extends('layouts.geral')

@section('conteudo')
    @include('partials.barra-pesquisa', [
        'acaoPesquisa' => route('pesquisa'),
        'placeholder' => 'Procurar questões...'
    ])
    <p>My Content</p>
@endsection