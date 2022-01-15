<div class="admin-moderador-card card d-inline-flex flex-row flex-nowrap">
    <div class="placeholder-glow admin-moderador-img-wrap">
        <img data-src="{{ asset($usr->utilizador->imagem_perfil) }}" class="d-none card-img-top admin-moderador-img" alt="Imagem de perfil de {{ $usr->utilizador->nome_utilizador }}">
        <div class="card-img-top placeholder col-12 h-100"></div>
    </div>
    <div class="card-body d-flex flex-column">
      <div>
        <h5 class="card-title">{{ $usr->utilizador->nome_utilizador }}</h5>
        <p class="card-text"><strong>Nome de apresentação:</strong> {{ $usr->utilizador->nome }}</p>
      </div>
      <div class="d-flex align-items-end flex-grow-1">
        <button class="btn btn-primary admin-moderador-acao" type="button" data-id="{{$usr->id_utilizador}}">Adicionar Moderador</button>
        <button type="button" class="btn btn-primary admin-moderador-acao-espera" data-id="{{ $usr->id_utilizador }}" disabled>
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          A processar
        </button>
      </div>
    </div>
</div>