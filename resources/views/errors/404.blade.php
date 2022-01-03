@extends('layouts.minimo')

@section('conteudo')
<div id="nao-encontrado-corpo">
    <img src="{{ asset('img/perdido.png') }}" alt="Rosa dos ventos. Dá a sensação de perda de orientação.">
    <h1>Nao há nada aqui! Parece que tentou aceder a uma página que não existe!</h1>
    <a href="{{ url()->previous() }}" type="button" class="btn btn-dark">Retornar à página anterior</a>
</div>
@endsection