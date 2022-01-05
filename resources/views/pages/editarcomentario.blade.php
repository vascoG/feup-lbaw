@extends('layouts.minimo')

@section('titulo')
Editar comentário
@endsection

@section('conteudo')
<div class="w-75 mx-auto mt-4">
    <form method = "POST" action="{{route('edit-comentario',[$questao->id, $comentario->id])}}" id="comentario-editar-form">
        {{ csrf_field() }}
        @method('PUT')
        <div class="form-group">
            <label for="texto">Corpo do comentário</label>
            <textarea required class="form-control questao-texto" id="textoComentario" name="texto" >{{$comentario->texto}}</textarea>
        </div>
    </form>
    <form method = "POST" action="{{route('eliminar-comentario',[$questao->id, $comentario->id])}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
    </form>
    <div>
        <button class="btn clearfix rounded-pill questao-button float-end" type="submit" form="comentario-editar-form" id="submit_button">
            <b>
                EDITAR COMENTÁRIO
            </b>
        </button>
        <button class="btn clearfix rounded-pill eliminar-button float-end" type="submit" form="questao-eliminar-form" id="submit_button">
            <b>
                ELIMINAR COMENTÁRIO
            </b>
        </button>
    </div>
</div>
@endsection