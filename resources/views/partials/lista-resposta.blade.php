<div class="container card-resposta">
  <div class="row">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{ asset(is_null($resposta->criador) ? App\Models\Utilizador::$imagemPadrao : $resposta->criador->utilizador->imagem_perfil) }}"></img>
        <p class="nome">{{is_null($resposta->criador) ? App\Models\Utilizador::$nomePadrao : $resposta->criador->utilizador->nome}}</p>
        <p class="text-muted">{{date('d/m/y H:i:s',strtotime($resposta->data_publicacao))}}</p>
      </div>
    </div>
    @if(!$resposta->resposta_aceite)
      <div class="col-9 corpo-questao">
    @else
      <div class= "col-9 corpo-resposta-aceite">
    @endif
    @can('verEliminar', $resposta)
      <form method = "POST" action="{{route('eliminar-resposta',[$questao->id,$resposta->id])}}" id="questao-eliminar-form">
        @csrf
        @method('DELETE')
        <button class="btn clearfix btn-sm eliminar-button float-end" type="submit" id="submit_button">
            <b>
                ELIMINAR RESPOSTA
            </b>
        </button>
      </form>
    @endcan
    @can('marcarCorreta', $resposta)
      <form method = "POST" action="{{route('resposta-correta',[$questao->id,$resposta->id])}}" id="questao-correta-form">
        @csrf
        @method('POST')
        <button class="btn clearfix btn-sm correta-button float-end" type="submit" id="submit_button">
            <b>
                RESPOSTA CORRETA
            </b>
        </button>
      </form>
    @endcan 
    @can('desmarcarCorreta', $resposta)
      <form method = "POST" action="{{route('retirar-resposta-correta',[$questao->id,$resposta->id])}}" id="questao-correta-form">
        @csrf
        @method('DELETE')
        <button class="btn clearfix btn-sm correta-button float-end" type="submit" id="submit_button">
            <b>
                RETIRAR RESPOSTA CORRETA
            </b>
        </button>
      </form>
    @endcan
    <div class="texto-interacoes">{{$resposta->texto}}</div>
    <hr>
    @can('editar', $resposta)
      <a href="{{route('editar-resposta',[$questao->id,$resposta->id])}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
    @endcan
    @can('interagir', $resposta)
      <button type="button" class="btn questao-button btn-sm float-end m-2 comentar-resposta" data-id="{{$resposta->id}}">Comentar</button>
      @if (Auth::user()->ativo->respostasAvaliadas()->where('id_resposta', $resposta->id)->exists())
            <button type="button" class="bi bi-hand-thumbs-down btn questao-button votar-resposta btn-sm float-end m-2" data-id="{{ $resposta->id }}">{{$resposta->numero_votos}}</button>
      @else
            <button type="button" class="bi bi-hand-thumbs-up btn votar-resposta questao-button btn-sm float-end m-2" data-id="{{ $resposta->id }}">{{$resposta->numero_votos}}</button>
      @endif
            <button type="button" class="btn votar-resposta btn-sm voto-resposta-acao-espera questao-button float-end m-2" data-id="{{ $resposta->id }}" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  A processar
            </button>
    @else
      <div class="btn btn-sm bi bi-hand-thumbs-up float-end m-2 mostrador-votos">{{$resposta->numero_votos}}</div>
    @endcan
    </div>
  </div> 
</div>

