@extends('layouts.geral')

@section('conteudo')
    @include('partials.barra-pesquisa', [
        'acaoPesquisa' => route('pesquisa')
    ])
    <p>My Content</p>
@endsection