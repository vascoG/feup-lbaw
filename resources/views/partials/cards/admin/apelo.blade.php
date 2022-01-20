<article class="card card-apelos p-2 my-3" data-id={{ $apelo->id }}>
    <div class="card-body card-apelos-body">
        <p class="card-text">{{ $apelo->motivo }}</p>
    </div>
    <div class="d-flex card-apelos-dados">
          <strong>  {{ $apelo->criador->utilizador->nome_utilizador}}</strong>
    </div>
    <div>
        @can ('admin',App\Utilizador::class)
        <form method = "POST" action="{{route('admin-bloqueia',$apelo->criador->utilizador->id)}}" id="bloqueia-utilizador-form">
            {{ csrf_field() }}
        <button type="submit" class="btn questao-button admin-apelo-acao bloquear btn-sm float-end m-2">Bloquear</button>
        </form>
        @endcan
        @can ('admin',App\Utilizador::class)
        <form method = "DELETE" action="{{route('admin-bloqueia',$apelo->criador->utilizador->id)}}" id="bloqueia-utilizador-form">
        <button type="button" class="btn questao-button admin-apelo-acao desbloquear btn-sm float-end m-2">Desbloquear</button>
        @endcan
    </div>
</article>
