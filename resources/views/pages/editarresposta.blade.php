@extends('layouts.minimo')

@section('conteudo')
<div class="w-75 mx-auto mt-4">
    <form method = "POST" action="{{route('edit-resposta',[$questao->id, $resposta->id])}}" id="resposta-editar-form">
        {{ csrf_field() }}
        @method('PUT')
        <div class="form-group">
            <label for="texto">Corpo da resposta</label>
            <textarea required class="form-control questao-texto" id="textoResposta" name="texto" >{{$resposta->texto}}</textarea>
        </div>
    </form>
    <form method = "POST" action="{{route('eliminar-resposta',[$questao->id, $resposta->id])}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
    </form>
    <div>
        <button class="btn clearfix rounded-pill questao-button float-end" type="submit" form="resposta-editar-form" id="submit_button">
            <b>
                EDITAR RESPOSTA
            </b>
        </button>
        <button class="btn clearfix rounded-pill eliminar-button float-end" type="submit" form="questao-eliminar-form" id="submit_button">
            <b>
                ELIMINAR RESPOSTA
            </b>
        </button>
    </div>
</div>
@endsection