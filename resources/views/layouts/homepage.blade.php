@extends('layouts.geral-no-footer')

@section('conteudo')
    <div class="flex-grow-1 d-flex flex-row">
        <div id="homepage-sidebar" class="d-flex flex-row shadow">
            <nav class="pe-2">
                <ul class="nav nav-pills nav-fill flex-column">
                    @if (Auth::check())
                      <li class="nav-item">
                        <a class="nav-link nav-link-wide {{ $selecionado=='para-si' ? "active" : "" }}" aria-current="page" href="{{ route('para-si') }}">Para si</a>
                      </li>
                    @endif
                    <li class="nav-item">
                      <a class="nav-link nav-link-wide {{ $selecionado=='tendencias' ? "active" : "" }}" aria-current="page" href="{{ route('tendencias') }}">Tendências</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link nav-link-wide {{ $selecionado=='etiquetas' ? "active" : "" }}" href="{{ route('homepage-etiquetas') }}">Etiquetas</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="homepage-conteudo" class="d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-end mb-3">
                @yield('barra-pesquisa')
            </div>
            <main>
              @yield('homepage-conteudo')
            </main>
        </div>
    </div>
@endsection