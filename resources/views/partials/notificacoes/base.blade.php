<article class="notificacao d-flex">
    @yield('conteudo-notificacao')
    <div class="vr mx-2"></div>
    <div class="link-secondary notificacao-underline dispensa-notificacao" role="button" data-id="{{ $notificacao->id }}">Dispensar</div>
</article>