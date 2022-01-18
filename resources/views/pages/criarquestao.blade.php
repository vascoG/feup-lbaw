@extends('layouts.minimo')

@section('titulo')
Criar Questão
@endsection

@section('conteudo')
<div class="w-75 mx-auto mt-4">
    <form method = "POST" action="{{route('criarquestao')}}" id="questao-form">
        @csrf
        <div class="form-group mb-3">
            <label for="tituloQuestao" class="form-label">Título da questão</label>
            <input required type="text" class="form-control" id="tituloQuestao" name="titulo" placeholder="Título">
        </div>
        <div class="form-group mb-3">
            <label for="textoQuestao" class="form-label">Corpo da questão</label>
            <textarea required class="form-control questao-texto" id="textoQuestao" name="texto" placeholder="Escreva aqui a sua questão"></textarea>
        </div>
        <div id="form-questao-etiquetas-container"  class="form-group">
            @include('partials.seletor-etiquetas')
        </div>
        <div class="mt-3">
            <button class="btn float-end clearfix rounded-pill questao-button submete-etiquetas" type="submit" id="submit_button">
                <b>
                    CRIAR QUESTÃO
                </b>
            </button>
        </div>
    </form>
</div>

@endsection