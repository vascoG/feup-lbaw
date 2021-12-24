<article class="lista-perfil">
    <h1>{{ $titulo }} ({{ $total }})</h1>
    <ul>
        @foreach ($colecao as $item)
            <li dara-id={{ $item['id'] }}>{{ $item['desc'] }}</li>
        @endforeach
    </ul>
    @if ($total > 4)
        <a href="#">Ver todas...</a>
    @endif
</article>
