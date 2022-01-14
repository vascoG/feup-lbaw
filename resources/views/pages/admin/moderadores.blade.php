@extends('layouts.admin-dashboard', [
    'selecionado' => 'moderadores'
])

@push('scripts')
    <script src="{{ asset('js/admin-moderadores.js') }}"></script>
@endpush

@section('titulo')
Administração de moderadores
@endsection


@section('conteudo') 

<div class="d-flex flex-column flex-nowrap justify-content-start ">
        @each('partials.cards.admin.moderador', $users, 'usr')
    </div>
    <div class="d-flex justify-content-center my-3">
    {{ $users->links() }}
</div>
@endsection