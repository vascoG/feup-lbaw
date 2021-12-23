@extends('layouts.geral')

@section('conteudo')
<div id="perfil-utilizador-erro">
    <img src='{{ asset('img/unknown-user.png') }}' alt='Utilizador Desconhecido'>
    <p>Oops! Parece que o utilizador que tentou procurar não existe</p>
    <a href="{{ route('home') }}" type="button" class="btn btn-dark">Retornar à homepage</a>
<div>
@endsection