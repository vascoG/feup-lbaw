@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('edit-questao',$questao->id)}}" id="questao-editar-form">
    {{ csrf_field() }}
    @method('PUT')
    <div class="form-group questao-titulo">
        <label for="titulo">Título da questão</label>
        <input required type="text" class="form-control " id="tituloQuestao" name="titulo" value="{{$questao->titulo}}">
    </div>
    <div class="form-group questao-titulo">
        <label for="texto">Corpo da questão</label>
        <textarea required class="form-control questao-texto" id="textoQuestao" name="texto" >{{$questao->texto}}</textarea>
    </div>
    <div class="form-group questao-titulo">
        @foreach ($tags as $etiqueta)
        <div class="form-check form-check-inline">
            @if ($questao->etiquetas->contains($etiqueta))
            <input class="form-check-input" type="checkbox" name="etiqueta[]" id="{{$etiqueta['id']}}" value="{{$etiqueta['id']}}" checked>
            <label class="form-check-label" for="{{$etiqueta['id']}}">{{$etiqueta['nome']}}</label>
            @else
            <input class="form-check-input" type="checkbox" name="etiqueta[]" id="{{$etiqueta['id']}}" value="{{$etiqueta['id']}}">
            <label class="form-check-label" for="{{$etiqueta['id']}}">{{$etiqueta['nome']}}</label> 
            @endif
        </div>
        @endforeach
       
    </div>
    <div >
        <button class="btn clearfix rounded-pill questao-button" type="submit" id="submit_button">
            <b>
                EDITAR QUESTÃO
            </b>
        </button>
    </div>

</form>


@endsection