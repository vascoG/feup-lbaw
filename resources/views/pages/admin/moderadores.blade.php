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
<div class="card-body card-questao">
        @foreach ($users as $user)
        <img class="mr-3 rounded-circle media" src="{{asset($user->utilizador->imagem_perfil)}}"></img>
        <p class="nome">{{$user->utilizadornome}}</p>
        @endforeach
</div>
<div class="d-flex flex-wrap justify-content-start gap-3 ps-4">
        @each('partials.moderador-completo', $users, 'users')
    </div>
    <div id="homepage-etiqueta-conexao-erro" class="toast position-absolute start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-dark">
          <strong class="me-auto">Ocorreu um erro ao submeter as alterações</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Verifique a sua ligação com a internet e tente novamente. 
        </div>
    </div>
@endsection