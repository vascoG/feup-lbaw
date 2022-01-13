<li class="d-flex justify-content-end align-items-center">
  <button id="reload-notificacoes" class="btn btn-outline-secondary py-1 px-2">
    <i class="bi bi-arrow-clockwise"></i>
  </button>
</li>
<li><hr></li>
@if(!Auth::user()->ativo->unreadNotifications->count())
  <li class="sem-notificacoes">Não há notificações a mostrar</li>
@else
  @each('partials.notificacoes.notificacao', Auth::user()->ativo->unreadNotifications()->orderBy('updated_at', 'desc')->get(), 'notificacao')
  <li><hr></li>
  <li><div id="dispensa-todas-notificacao" class="link-secondary notificacao-underline" role="button">Dispensar todas</div></li>
@endif