@extends('layouts.geral')

@section('conteudo')
    <div class="pe-3 flex-grow-1 d-flex flex-row">
        <div class="d-flex flex-row">
            <nav class="pe-2">
                <ul class="nav nav-pills nav-fill flex-column">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Much longer nav link</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-end mb-3">
                @include('partials.barra-pesquisa', [
                    'acaoPesquisa' => route('pesquisa'),
                    'placeholder' => 'Procurar questões...'
                ])
            </div>
        </div>
    </div>
@endsection