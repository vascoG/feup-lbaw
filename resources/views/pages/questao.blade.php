@extends('layouts.minimo')

@section('conteudo')

<div class="container">
  <div class="row">
    <div class="col">
      <div class="media">
        <img class="mr-3 rounded-circle" alt="Foto Perfil" src="{{$criador->imagem_perfil}}"></img>
        <p>Nome {{$criador->nome}}</p>
        <p class="text-muted">{{$questao->data_publicacao}}</p>
      </div>
    </div>
    <div class="col">
      <br>
    <p> Texto {{$questao->texto}}.</p>
    </div>
    <div class="col">
    </div>
  </div>
  <div class="row">
    <div class="col">
    <div class="badge bg-primary text-wrap" style="width: 6rem;">
      Gosto
    </div>
    <div class="badge bg-primary text-wrap" style="width: 6rem;">
      Não Gosto
    </div>
    </div>
    <div class="col">
    </div> 
    <div class="col">
      <div class="badge bg-primary text-wrap" style="width: 6rem;">
        Responder
      </div>
      <div class="badge bg-primary text-wrap" style="width: 6rem;">
        Comentar
      </div>
    </div>
  </div>
</div>
<hr> 



@endsection