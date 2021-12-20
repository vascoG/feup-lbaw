<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LBAW2191') }}</title>

    <!-- Styles -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href={{ asset('css/app.css') }} rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
  </head>
  <body>
      <header id="geral-header" class="shadow-lg">
        <div class="hstack gap-3">
          @include('layouts.logo-text')
          <div class="ms-auto">
            <nav id="geral-header-navbar">
              <a class="link-header" href="https://www.google.com">Sobre nós</a>
              <a class="link-header" href="https://www.google.com">Serviços</a>
              <a class="link-header" href="https://www.google.com">FAQ</a>
              <a class="link-header" href="https://www.google.com">Contactos</a>
            </nav>
          </div>
          <div class="vr" id="header-vr"></div>
          <div>
            @if (Auth::check())
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ Auth::user()->nome }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">Perfil</a></li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </div>
            @else
              <a class="link-header"href="{{ route('login') }}">Login</a>
            @endif
          </div>
        </div>
      </header>
      <section id="conteudo">
        @yield('conteudo')
      </section>
      @include('layouts.footer')
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
