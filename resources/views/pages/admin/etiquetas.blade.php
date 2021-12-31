@extends('layouts.admin-dashboard', [
    'selecionado' => 'etiquetas'
])

@push('scripts')
    <script src="{{ asset('js/admin-etiquetas.js') }}"></script>
@endpush

@section('conteudo')
<div id="admin-etiquetas">
    <div class="d-flex justify-content-end">
        @include('partials.barra-pesquisa', [
            'acaoPesquisa' => route('etiquetas'),
            'placeholder' => 'Nome da etiqueta...'
        ])
    </div>
    <div>
        @each('pages.admin.etiqueta', $etiquetas, 'etiqueta')
    </div>
</div>
@endsection