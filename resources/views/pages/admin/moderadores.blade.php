@extends('layouts.admin-dashboard', [
    'selecionado' => 'moderadores'
])

@push('scripts')
    <script src="{{ asset('js/clicavel.js') }}"></script>
    <script src="{{ asset('js/admin-moderadores.js') }}"></script>
@endpush

@section('titulo')
Administração de moderadores
@endsection


@section('conteudo')
<div class="mx-3">
    <div class="d-flex justify-content-end my-3">
        @include('partials.barra-pesquisa', [
            'acaoPesquisa' => route('admin-moderadores'),
            'placeholder' => 'Introduza o nome do utilizador',
            'query' => $query
        ])
    </div>

    <div class="d-flex flex-column flex-nowrap justify-content-start ">
            @each('partials.cards.admin.moderador', $users, 'usr')
        </div>
        <div class="d-flex justify-content-center my-3">
        {{ $users->links() }}
    </div>
</div>
@endsection