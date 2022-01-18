@extends('layouts.minimo')

@push('scripts')
    <script src="{{ asset('js/questao.js') }}"></script>
    <script src="{{ asset('js/questao-votos.js') }}"></script>
    <script src="{{ asset('js/resposta-voto.js') }}"></script>
@endpush

@section('titulo')
{{ $questao->titulo }}
@endsection
@section('conteudo')
<div class="container ">
  <div class="row">
    <div class="col-3">
      <div class="media">
        <img class="mr-3 rounded-circle" src="{{ asset(is_null($criador) ? App\Models\Utilizador::$imagemPadrao : $criador->imagem_perfil) }}"></img>
        <p class="nome">{{ is_null($criador) ? App\Models\Utilizador::$nomePadrao : $criador->nome }}</p>
        <p class="text-muted">{{ date('d/m/y H:i:s',strtotime($questao->data_publicacao)) }}</p>
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
      @can('editar', $questao)
        <a href="{{route('editar-questao',$questao->id)}}"><button type="button" class="btn questao-button btn-sm float-end m-2">Editar</button></a>
      @endcan
      @can('interagir', $questao)
        <a href="#formResposta"><button type="button" class="btn questao-button responder btn-sm float-end m-2">Responder</button></a>
        <a href="#formComentario"><button type="button" class="btn questao-button comentar-questao btn-sm float-end m-2">Comentar</button></a>
        @if (Auth::user()->ativo->questoesAvaliadas()->where('id_questao', $questao->id)->exists())
          <button type="button" class="bi bi-hand-thumbs-down btn questao-button votar-questao btn-sm float-end m-2" data-id="{{ $questao->id }}"> {{$questao->numero_votos}}</button>
        @else
          <button type="button" class="bi bi-hand-thumbs-up btn votar-questao questao-button btn-sm float-end m-2" data-id="{{ $questao->id }}"> {{$questao->numero_votos}}</button>
        @endif
          <button type="button" class="btn votar-questao btn-sm voto-acao-espera questao-button float-end m-2" data-id="{{ $questao->id }}" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              A processar
          </button>
      @endcan
    </div>
  </div> 
  @foreach ($questao->comentarios as $comentario)
      @include('partials.lista-comentario',['comentario'=>$comentario])
  @endforeach
    @foreach ($respostas as $resposta)
      @include('partials.lista-resposta',['resposta'=>$resposta])
      @foreach ($resposta->comentarios as $comentario)
        @include('partials.lista-comentario',['comentario'=>$comentario])
      @endforeach
    @endforeach
  <hr class="interacoes-questao">
  <div>
    <form method = "POST" action="{{route('criar-resposta',$questao->id)}}"  id="formResposta"  class="hidden">
    {{ csrf_field() }}
      <div class="label-publicar">
      <label>Resposta à questão: </label>
      </div>
      <textarea class="form-group questao-interacao" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>
  <div>
    <form method = "POST" action="{{route('criar-comentario',$questao->id)}}"  id="formComentario"  class="hidden">
    {{ csrf_field() }}
    <div class="label-publicar">
      <label>Comentário à questão: </label>
      </div>
      <textarea class="form-group questao-interacao" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>
  <div>
    <form method = "POST" action="{{route('criar-comentario-resposta', [$questao->id,0])}}"  id="formComentarioResposta"  class="hidden">
    {{ csrf_field() }}
    <div class="label-publicar">
      <label>Comentário à resposta: </label>
      </div>
      <textarea class="form-group questao-interacao" name="texto"></textarea>
      <div>
      <button type="submit" class="btn publicar-button btn-sm" >Publicar</button>
      </div>
    </form>
  </div>
  </div>



@endsection