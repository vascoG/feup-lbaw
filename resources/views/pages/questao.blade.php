@extends('layouts.minimo')

@push('scripts')
    <script src="{{ asset('js/questao.js') }}"></script>
    <script src="{{ asset('js/questao-votos.js') }}"></script>
@endpush

@section('titulo')
{{ $questao->titulo }}
@endsection

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
      @if($user!=null)
    @if($user->moderador)
      <form method = "POST" action="{{route('eliminar-questao',$questao->id)}}" id="questao-eliminar-form">
        {{ csrf_field() }}
        @method('DELETE')
        <button class="btn clearfix btn-sm eliminar-button float-end" type="submit" id="submit_button">
            <b>
                ELIMINAR QUESTÃO
            </b>
        </button>
        </form>
        @endif
        @endif
      <h3>{{$questao->titulo}}</h3>
      <div class= "texto-interacoes">{{$questao->texto}}</div>
      <hr>
      @foreach ($questao->etiquetas as $etiqueta)
      <span class="badge badge-pill badge-tag">
      {{$etiqueta->nome}}
      </span>
      @endforeach
      @if($user!=null)
      @if($user->id == $questao->criador->id_utilizador)
      <a href="{{route('editar-questao',$questao->id)}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
      @else
      <button type="button" class="btn questao-button responder btn-sm float-end m-2">Responder</button>
      <button type="button" class="btn questao-button comentar-questao btn-sm float-end m-2">Comentar</button>
      @auth
      @if (Auth::user()->ativo->votaQuestao($questao))
            <button type="button" class="bi bi-hand-thumbs-up btn questao-button votar btn-sm float-end m-2" data-id="{{ $questao->id }}">Não Gosto</button>
      @else
            <button type="button" class="bi bi-hand-thumbs-up btn questao-button votar btn-sm float-end m-2" data-id="{{ $questao->id }}">Gosto</button>
      @endif
      <button type="button" class="flex-grow-1 btn btn-primary homepage-etiqueta-acao-espera" data-id="{{ $questao->id }}" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
           A processar
      </button>
      @endauth
      @endif
      @endif

    </div>
  </div> 
  @foreach ($questao->comentarios as $comentario)
      @include('partials.lista-comentario',['comentario'=>$comentario, 'user'=>$user])
  @endforeach
    @foreach ($questao->respostas as $resposta)
      @include('partials.lista-resposta',['resposta'=>$resposta,'user'=>$user])
      @foreach ($resposta->comentarios as $comentario)
        @include('partials.lista-comentario',['comentario'=>$comentario,'user'=>$user])
      @endforeach
    @endforeach
</div>
  <div>
    <form method = "POST" action="{{route('criar-resposta',$questao->id)}}"  id="formResposta"  class="hidden">
    {{ csrf_field() }}
      <textarea class="form-group questao-texto questao-titulo" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>
  <div>
    <form method = "POST" action="{{route('criar-comentario',$questao->id)}}"  id="formComentario"  class="hidden">
    {{ csrf_field() }}
      <textarea class="form-group questao-texto questao-titulo" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>
  <div>
    <form method = "POST" action="{{route('criar-comentario-resposta', [$questao->id,0])}}"  id="formComentarioResposta"  class="hidden">
    {{ csrf_field() }}
      <textarea class="form-group questao-texto questao-titulo" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>



@endsection