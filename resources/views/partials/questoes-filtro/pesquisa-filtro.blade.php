@push('scripts')
    <script src="{{ asset('js/filtro-etiquetas.js') }}"></script>
@endpush

<div>
    <form method="GET" action={{ route('pesquisa') }}>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="accordion-header">
                    @include('partials.campo-query-pesquisa')
                </div>
            </div>
        @include('partials.campo-query-pesquisa')
        @include('partials.questoes-filtro.etiquetas')
        @include('partials.questoes-filtro.ordenacao-atributo')
        @include('partials.questoes-filtro.ordenacao-ordem')
        <hr>
        </div>
    </form>
</div>