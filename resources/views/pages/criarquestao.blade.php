@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('criarquestao')}}" id="questao-form">
    {{ csrf_field() }}
    <div class="form-group questao-titulo">
        <label for="titulo">Título da questão</label>
        <input required type="text" class="form-control" id="tituloQuestao" name="titulo" placeholder="Título">
    </div>
    <div class="form-group questao-titulo">
        <label for="texto">Corpo da questão</label>
        <textarea required class="form-control questao-texto" id="textoQuestao" name="texto" placeholder="Escreva aqui a sua questão"></textarea>
    </div>
    <div class="form-group container ">
        @foreach ($tags as $etiqueta)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="etiqueta[]" id="{{$etiqueta['id']}}" value="{{$etiqueta['id']}}">
            <label class="form-check-label" for="{{$etiqueta['id']}}">{{$etiqueta['nome']}}</label>
        </div>
        @endforeach
       
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