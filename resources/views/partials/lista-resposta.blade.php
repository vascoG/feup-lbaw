<div class="container">
  <div class="row">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{$resposta->criador->utilizador->imagem_perfil}}"></img>
        <p class="nome">{{$resposta->criador->utilizador->nome}}</p>
        <p class="text-muted">{{date('d/m/y H:i:s',strtotime($resposta->data_publicacao))}}</p>
      </div>
    </div>
    <div class="col-9 corpo-questao">
      {{$resposta->texto}}
      <hr>
      <button type="button" class="btn questao-button btn-sm float-end m-2">Comentar</button>
    </div>
  </div> 
</div>

