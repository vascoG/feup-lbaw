<article class="lista-perfil">
    <h1>{{ $titulo }} ({{ $total }})</h1>
    <ul>
        @foreach ($colecao as $item)
            <li><a class="link-secondary" href="{{ $rotaMap($item) }}">{{ $item['desc'] }}</a></li>
        @endforeach
    </ul>
    @if ($total > 4)
        <a href="{{ $rotaVerMais }}">Ver todas...</a>
    @endif
</article>
