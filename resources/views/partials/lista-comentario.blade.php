<div class="container">
  <div class="row">
    <div class="col-3">
    </div>
        <div class="col-2">
        <div class="media-comentario">
            <img class="mr-3 rounded-circle nome" src="{{ asset($comentario->criador->utilizador->imagem_perfil) }}"></img>
            <p class="nome">{{$comentario->criador->utilizador->nome}}</p>
            <p class="text-muted">{{date('d/m/y H:i:s',strtotime($comentario->data_publicacao))}}</p>
        </div>
        </div>
        <div class="col-7 corpo-comentario ">
          @if($user!=null)
    @if($user->moderador)
      <form method = "POST" action="{{route('eliminar-comentario',[$questao->id,$comentario->id])}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
        <button class="btn clearfix btn-sm eliminar-button float-end" type="submit" id="submit_button">
            <b>
                ELIMINAR COMENTÁRIO
            </b>
        </button>
        </form>
        @endif
        @endif<div class="texto-interacoes">{{$comentario->texto}}
        <hr>
        @if($user!=null)
        @if($user->id == $comentario->criador->id_utilizador)
        <a href="{{route('editar-comentario',[$questao->id,$comentario->id])}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
        @endif
        @endif
    
</div>
        </div>
  </div> 
</div>