@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('criarquestao')}}" id="questao-form">
    {{ csrf_field() }}


@endsection