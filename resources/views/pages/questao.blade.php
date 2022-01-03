@extends('layouts.minimo')

@section('conteudo')

<div class="container ">
  <div class="row ">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{asset($criador->imagem_perfil)}}"></img>
        <p class="nome">{{$criador->nome}}</p>
        <p class="text-muted">{{date('d/m/y H:i:s',strtotime($questao->data_publicacao))}}</p>
      </div>
    </div>
    <div class="col-9 corpo-questao">
      <h3>{{$questao->titulo}}</h3>
      <div class= "texto-interacoes">{{$questao->texto}}</div>
      <hr>
      @foreach ($questao->etiquetas as $etiqueta)
      <span class="badge badge-pill badge-tag">
      {{$etiqueta->nome}}
      </span>
      @endforeach
      <button type="button" class="btn questao-button btn-sm float-end m-2" >Responder</button>
      <button type="button" class="btn questao-button btn-sm float-end m-2">Comentar</button>
    </div>
  </div> 
  @foreach ($questao->comentarios as $comentario)
      @include('partials.lista-comentario',['comentario'=>$comentario])
  @endforeach
    @foreach ($questao->respostas as $resposta)
      @include('partials.lista-resposta',['resposta'=>$resposta])
      @foreach ($resposta->comentarios as $comentario)
        @include('partials.lista-comentario',['comentario'=>$comentario])
      @endforeach
    @endforeach
</div>



@endsection