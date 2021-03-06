<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('titulo') - {{ config('app.name', 'LBAW2191') }}</title>

  <!-- Styles -->
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link href={{ asset('css/app.css') }} rel="stylesheet">
  <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
</head>

<body>
  <div class="altura-max">
    <header class="shadow-lg">
      <div class="hstack gap-3">
        @include('layouts.logo-text')
        <div class="ms-auto">
          <nav id="geral-header-navbar">
            <a class="link-header" href="{{ route('sobre-nos') }}">Sobre nós</a>
            <a class="link-header" href="{{ route('faq') }}">FAQ</a>
            <a class="link-header" href="{{ route('contactos') }}">Contactos</a>
          </nav>
        </div>
        <div class="vr" id="header-vr"></div>
        <div>
          @if (Auth::check())
            <div class="btn-group" role="group" aria-label="Dados do utilizador">
              <div class="dropdown btn-group">
                <button id="botao-mostra-notificacao" class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::user()->ativo->unreadNotifications->count())
                      <i class="bi bi-bell-fill"></i>
                    @else
                      <i class="bi bi-bell"></i>
                    @endif
                </button>
                <ul id="lista-notificacoes" class="dropdown-menu p-3" aria-labelledby="botao-mostra-notificacao">
                  @include('partials.notificacoes.lista-notificacoes')
                </ul>
              </div>
              <div class="dropdown btn-group">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="navbar-paginas-utilizador"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  {{ Auth::user()->nome }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="navbar-paginas-utilizador">
                  @can('admin', App\Models\Utilizador::class)
                    <li><a class="dropdown-item" href="{{ route('admin') }}">Página de Administração</a></li>
                  @endcan
                  <li><a class="dropdown-item" href="{{ route('perfil', ['nomeUtilizador' => Auth::user()->nome_utilizador]) }}">Perfil</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
              </div>
            </div>
          @else
            <a class="link-header" href="{{ route('login') }}">Login</a>
          @endif
        </div>
      </div>
    </header>
    <main id="conteudo">
      @yield('conteudo')
    </main>
    @stack('footer')
  </div>
  <div id="erro-conexao" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-warning text-dark">
      <strong class="me-auto">Ocorreu um erro ao submeter as alterações</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Verifique a sua ligação com a internet e tente novamente. 
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/notificacoes.js') }}"></script>
  @stack('scripts')
</body>

</html>