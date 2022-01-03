<article class="d-flex flex-column flex-nowrap etiqueta-card" data-id={{ $etiqueta->id }}>
    <p class="flex-grow-1">{{ $etiqueta->nome }}</p>
    @yield('controlos')
</article>