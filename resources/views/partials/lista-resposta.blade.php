<div class="container">
  <div class="row">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{ asset($resposta->criador->utilizador->imagem_perfil) }}"></img>
        <p class="nome">{{$resposta->criador->utilizador->nome}}</p>
        <p class="text-muted">{{date('d/m/y H:i:s',strtotime($resposta->data_publicacao))}}</p>
      </div>
    </div>
    <div class="col-9 corpo-questao">
    @if($user!=null)
    @if($user->moderador)
      <form method = "POST" action="{{route('eliminar-resposta',[$questao->id,$resposta->id])}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
        <button class="btn clearfix btn-sm eliminar-button float-end" type="submit" id="submit_button">
            <b>
                ELIMINAR RESPOSTA
            </b>
        </button>
        </form>
        @endif
        @endif
      <div class="texto-interacoes">{{$resposta->texto}}</div>
      <hr>
      @if($user!=null)
      @if($user->id == $resposta->criador->id_utilizador)
      <a href="{{route('editar-resposta',[$questao->id,$resposta->id])}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
      @else
      <button type="button" class="btn questao-button btn-sm float-end m-2 comentar-resposta" data-id="{{$resposta->id}}">Comentar</button>
      @auth
          @if (Auth::user()->ativo->respostasAvaliadas()->where('id_resposta', $resposta->id)->exists())
                <button type="button" class="bi bi-hand-thumbs-down btn questao-button votar-resposta btn-sm float-end m-2" data-id="{{ $resposta->id }}"> $resposta->getNumeroVotosAttribute</button>
          @else
                <button type="button" class="bi bi-hand-thumbs-up btn votar-resposta questao-button btn-sm float-end m-2" data-id="{{ $resposta->id }}"> Gosto</button>
          @endif
                <button type="button" class="btn votar-resposta btn-sm voto-resposta-acao-espera questao-button float-end m-2" data-id="{{ $resposta->id }}" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      A processar
                </button>
        @endauth
      @endif
      @endif
    </div>
  </div> 
</div>

