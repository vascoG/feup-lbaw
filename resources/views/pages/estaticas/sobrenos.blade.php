@extends('layouts.geral')

@section('conteudo')

<div class="pagina-estaticas">
  <h1>Sobre nós</h1>
  <p>FinJet é um site que nasceu em 2021 de forma a ajudar os nossos utilizadores na área das finanças pessoais.</p>
  <p>Este site está disponível para qualquer pessoa com interesse na área e deve ser utilizado colaborativamente.</p>
</div>

<h2 style="text-align:center">A Nossa Equipa</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="vasco.png" alt="Vasco Gomes" style="width:100%">
      <div class="container">
        <h2>Vasco Gomes</h2>
        <p class="title">CEO & Founder</p>
        <p>Descrição da pessoa.</p>
        <p>vasco@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="mariana.png" alt="Mike" style="width:100%">
      <div class="container">
        <h2>Mariana Monteiro</h2>
        <p class="title">CEO & Founder</p>
        <p>Descrição da pessoa.</p>
        <p>mariana@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="francisco.png" alt="John" style="width:100%">
      <div class="container">
        <h2>Francisco Oliveira </h2>
        <p class="title">CEO & Founder</p>
        <p>Descrição da pessoa.</p>
        <p>francisco@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
</div>
@endsection