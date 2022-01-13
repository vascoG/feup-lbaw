<article class="card card-apelos p-2 my-3" data-id={{ $apelo->id }}>
    <div class="card-body card-apelos-body">
        <p class="card-text">{{ $apelo->motivo }}</p>
    </div>
    <div class="d-flex card-apelos-dados">
          <strong>  {{ $apelo->criador->utilizador->nome_utilizador}}</strong>
    </div>
    <div>
        <button type="button" class="btn questao-button admin-apelo-acao bloquear btn-sm float-end m-2">Bloquear</button>
        <button type="button" class="btn questao-button admin-apelo-acao desbloquear btn-sm float-end m-2">Desbloquear</button>
    </div>
</article>