<div class="container">
  <div class="row">
    <div class="col-3">
    </div>
        <div class="col-2">
        <div class="media-comentario">
            <img class="mr-3 rounded-circle nome" src="{{$comentario->criador->utilizador->imagem_perfil}}"></img>
            <p class="nome">{{$comentario->criador->utilizador->nome}}</p>
            <p class="text-muted">{{date('d/m/y H:i:s',strtotime($comentario->data_publicacao))}}</p>
        </div>
        </div>
        <div class="col-7 corpo-comentario texto-interacoes">{{$comentario->texto}}
        <hr>
        </div>
  </div> 
</div>