@extends('layouts.minimo')

@section('titulo')
Criar Apelo
@endsection

@section('conteudo')
<div class="w-75 mx-auto mt-4">
    <form method = "POST" action="{{route('criar-apelo',$nomeUtilizador)}}" id="apelo-form">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="texto" class="form-label">Motivo do apelo</label>
            <textarea required class="form-control motivo-texto" id="motivoApelo" name="texto" placeholder="Escreva aqui o seu motivo"></textarea>
        </div>
            <button class="btn float-end clearfix rounded-pill questao-button" type="submit" id="submit_button">
                <b>
                    CRIAR APELO
                </b>
            </button>
    </form>
<div>

@endsection