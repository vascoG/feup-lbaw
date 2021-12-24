@extends('layouts.minimo')

@section('conteudo')
<div id="sem-permissoes-corpo">
    <img src="{{ asset('img/sem-permissao.png') }}">
    <h1>Parece que tentou efetuar uma operação para a qual não tem permissões!</h1>
    <a href="{{ url()->previous() }}" type="button" class="btn btn-dark">Retornar à página anterior</a>
</div>
@endsection