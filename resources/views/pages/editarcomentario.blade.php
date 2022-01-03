@extends('layouts.minimo')

@section('conteudo')
<form method = "POST" action="{{route('edit-comentario',[$questao->id, $comentario->id])}}" id="comentario-editar-form">
    {{ csrf_field() }}
    @method('PUT')
    <div class="form-group questao-titulo">
        <label for="texto">Corpo do comentário</label>
        <textarea required class="form-control questao-texto" id="textoComentario" name="texto" >{{$comentario->texto}}</textarea>
    </div>
        <button class="btn clearfix rounded-pill questao-button" type="submit" id="submit_button">
            <b>
                EDITAR COMENTÁRIO
            </b>
        </button>

</form>


@endsection