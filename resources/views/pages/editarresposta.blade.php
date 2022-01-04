@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('edit-resposta',[$questao->id, $resposta->id])}}" id="resposta-editar-form">
    {{ csrf_field() }}
    @method('PUT')
    <div class="form-group questao-titulo">
        <label for="texto">Corpo da resposta</label>
        <textarea required class="form-control questao-texto" id="textoResposta" name="texto" >{{$resposta->texto}}</textarea>
    </div>
    <div>
        <button class="btn clearfix rounded-pill questao-button float-end" type="submit" id="submit_button">
            <b>
                EDITAR RESPOSTA
            </b>
        </button>
        </form>
        <form method = "POST" action="{{route('eliminar-resposta',[$questao->id, $resposta->id])}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
        <button class="btn clearfix rounded-pill eliminar-button float-end" type="submit" id="submit_button">
            <b>
                ELIMINAR RESPOSTA
            </b>
        </button>
        </form>
</div>



@endsection