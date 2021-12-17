@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('criarquestao')}}" id="questao-form">
    {{ csrf_field() }}
    <div class="form-group ">
        <label for="titulo">Título da questão</label>
        <input required type="text" class="form-control questao-titulo" id="tituloQuestao" name="titulo" placeholder="Título">
    </div>
    <div class="form-group ">
        <label for="texto">Corpo da questão</label>
        <textarea required class="form-control questao-texto" id="textoQuestao" name="texto" placeholder="Escreva aqui a sua questão"></textarea>
    </div>
    <div class="form-group ">
        <label for="etiqueta">Tags</label>
        <textarea class="form-control questao-titulo" id="etiquetaQuestao" name="etiqueta" placeholder="Ainda não está implementado..."></textarea>
    </div>
    <div >
        <button class="btn float-end clearfix rounded-pill questao-button" type="submit" id="submit_button">
            <b>
                CRIAR QUESTÃO
            </b>
        </button>
    </div>

</form>


@endsection