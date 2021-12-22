@extends('layouts.minimo')

@section('conteudo')


<div class="pagina-estaticas">
    <h3 class="text-center mb-4 pb-2 text-faq fw-bold">Preguntas Frequentes</h3>
    <p class="text-center mb-5">Descobre as respostas para as perguntas mais frequentes abaixo!</p>
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq"> Como posso criar questões?</h6>
        <p>Para criar questões, tem de registar-se no nosso site e assim conseguirá fazer publicações.</p>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq">É possível associar mais que uma tag à minha questão?</h6>
        <p>
            <strong><u>Sim, é possível!</u></strong>Pode adicionar mais que uma tags.</p>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq"> O que posso fazer no site sem me registar?</h6>
        <p>Apenas pode ter acesso às publicações porém não pode interagir com as mesmas.</p>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq">É possível apagar respostas de outros utilizadores à minha questão?</h6>
        <p>Não.</p>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq"> Posso votar nas minhas publicações?</h6>
        <p>Não é possível realizar interações com as própias publicações, seja votar, responder ou comentar.</p>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
        <h6 class="mb-3 text-faq">Se eu eliminar conta as minhas publicações são eliminadas?</h6>
        <p> Não, caso decida desativar a sua conta as publicações passam a pertencer a um utilizador anónimo.</p>
        </div>
    </div>
</div>

@endsection