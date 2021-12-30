@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('edit-resposta',[$questao->id, $resposta->id])}}" id="resposta-editar-form">
    {{ csrf_field() }}
    @method('PUT')
    <div class="form-group questao-titulo">
        <label for="texto">Corpo da resposta</label>
        <textarea required class="form-control questao-texto" id="textoResposta" name="texto" >{{$resposta->texto}}</textarea>
    </div>
        <button class="btn clearfix rounded-pill questao-button" type="submit" id="submit_button">
            <b>
                EDITAR RESPOSTA
            </b>
        </button>

</form>


@endsection