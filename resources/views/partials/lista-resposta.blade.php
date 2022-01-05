<div class="container">
  <div class="row">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{ asset($resposta->criador->utilizador->imagem_perfil) }}"></img>
        <p class="nome">{{$resposta->criador->utilizador->nome}}</p>
        <p class="text-muted">{{date('d/m/y H:i:s',strtotime($resposta->data_publicacao))}}</p>
      </div>
    </div>
    <div class="col-9 corpo-questao"><div class="texto-interacoes">{{$resposta->texto}}</div>
      <hr>
      @if($user == $resposta->criador->id_utilizador)
      <a href="{{route('editar-resposta',[$questao->id,$resposta->id])}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
      @else
      <button type="button" class="btn questao-button btn-sm float-end m-2 comentar-resposta" data-id="{{$resposta->id}}">Comentar</button>
      @endif
    </div>
  </div> 
</div>

