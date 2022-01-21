<div class="container">
  <div class="row">
    <div class="col-3"></div>
        <div class="col-2">
        <div class="media-comentario">
            <img class="mr-3 rounded-circle nome" src="{{ asset(is_null($comentario->criador) ? App\Models\Utilizador::$imagemPadrao : $comentario->criador->utilizador->imagem_perfil) }}" alt="Avatar do criador do comentário">
            @if(!is_null($comentario->criador))
              <a class="link-questao-nome-utilizador" href="{{ route('perfil', $comentario->criador->utilizador->nome_utilizador) }}">{{ $comentario->criador->utilizador->nome }}</a>
            @else
              <p>{{ App\Models\Utilizador::$nomePadrao }}</p>
            @endif
            <p class="text-muted">{{date('d/m/y H:i:s',strtotime($comentario->data_publicacao))}}</p>
        </div>
        </div>
        <div class="col-7 corpo-comentario ">
          @can('verEliminar', $comentario)
            <form method = "POST" action="{{route('eliminar-comentario',[$questao->id,$comentario->id])}}" id="questao-eliminar-form">
              @csrf
              @method('DELETE')
              <button class="btn clearfix btn-sm eliminar-button float-end" type="submit" id="submit_button">
                  <b>
                      ELIMINAR COMENTÁRIO
                  </b>
              </button>
            </form>
          @endcan
          <div class="texto-interacoes">{{$comentario->texto}}
            <hr>
            @can('editar', $comentario)
              <a class="btn questao-button btn-sm float-end m-2" href="{{route('editar-comentario', [$questao->id, $comentario->id])}}">Editar</a>
            @endcan
          </div>
        </div>
  </div> 
</div>