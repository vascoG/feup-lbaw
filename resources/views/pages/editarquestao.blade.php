@extends('layouts.minimo')

@section('titulo')
Editar questão
@endsection

@section('conteudo')
<div class="w-75 mx-auto mt-4">
    <form method = "POST" action="{{route('edit-questao',$questao->id)}}" id="questao-editar-form">
        @csrf
        @method('PUT')
        @can('editarConteudo')
            <div class="form-group mb-3">
                <label for="tituloQuestao" class="form-label">Título da questão</label>
                <input required type="text" class="form-control" id="tituloQuestao" name="titulo" value="{{$questao->titulo}}">
            </div>
            <div class="form-group mb-3">
                <label for="textoQuestao" class="form-label">Corpo da questão</label>
                <textarea required class="form-control questao-texto" id="textoQuestao" name="texto" >{{$questao->texto}}</textarea>
            </div>
        @endcan
        <div id="form-questao-etiquetas-container" class="form-group">
            @include('partials.seletor-etiquetas', [
                'etiquetas'
            ])
        </div>
    </form>
    <form method = "POST" action="{{route('eliminar-questao',$questao->id)}}" id="questao-eliminar-form">
        @csrf
        @method('DELETE')
    </form>
    <div class="d-flex justify-content-end mt-3">
        <button class="btn clearfix rounded-pill questao-button submete-etiquetas" type="submit" form="questao-editar-form">
            <b>
                EDITAR QUESTÃO
            </b>
        </button>
        <button class="btn clearfix rounded-pill eliminar-button" type="submit" form="questao-eliminar-form">
            <b>
                ELIMINAR QUESTÃO
            </b>
        </button>
    </div>
</div>
@endsection