<article class="perfil-interacoes">
    <h1>As minhas questões: {{ $usr->questoes->count() }}</h1>
    <ul>
        @foreach ($usr->questoes(4) as $questao)
            <li>{{ $questao->titulo }}</li>
        @endforeach
        <li>asdfasdfasdfasdfhgasjkdfhgkasjdhfgaksjdfghakjsdfhgajksdfhgajksdhfgakjsdfghaksjdhfgakjsdhfgasjkdghf</li>
        <li>asdfasdfasdfasdfhgasjkdfhgkasjdhfgaksjdfghakjsdfhgajksdfhgajksdhfgakjsdfghaksjdhfgakjsdhfgasjkdghf</li>
        <li>asdfasdfasdfasdfhgasjkdfhgkasjdhfgaksjdfghakjsdfhgajksdfhgajksdhfgakjsdfghaksjdhfgakjsdhfgasjkdghf</li>
    </ul>
    @if ($usr->questoes->count() > 4) {
        <a href="#">Ver todas...</a>
    }
    @endif
</article>