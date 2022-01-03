@extends('layouts.homepage')

@section('barra-pesquisa')
    @include('partials.barra-pesquisa', [
        'acaoPesquisa' => route('pesquisa'),
        'placeholder' => 'Procurar questões...'
    ])
@endsection

@section('homepage-conteudo')
<div style="border: 5px solid red">
    asdfasdf
</div>
@endsection