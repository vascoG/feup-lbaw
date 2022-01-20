@extends('layouts.minimo')

@section('titulo')
    Permissão Negada
@endsection

@section('conteudo')
<div id="sem-permissoes-corpo">
    <img src="{{ asset('img/sem-permissao.png') }}" alt="Sinal de paragem obrigatória para dar a sensação de proibição de acesso à página.">
    <h1>Parece que tentou efetuar uma operação para a qual não tem permissões!</h1>
    <a href="{{ url()->previous() }}" type="button" class="btn btn-dark">Retornar à página anterior</a>
</div>
@endsection