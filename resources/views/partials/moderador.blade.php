<article class="d-flex flex-column flex-nowrap moderador-card" data-id={{ $users->id_utilizador }}>
    <p class="flex-grow-1">{{ $users->utilizador->nome_utilizador }}</p>
    @yield('controlos')
</article>