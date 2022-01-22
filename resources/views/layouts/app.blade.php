<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ secure_asset('/software/favicon2.0.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ secure_asset('/software/favicon2.0.png') }}">

    <title>TakeAPic</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    <script src="{{ secure_asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="/takeapic/public/software/favicon2.0.png" alt=""  height="25" class="d-inline-block align-text-top">
                    TakeAPic
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else                                              
                        
                        @if(Auth::user()->role == 'admin' )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('comment') }}">Reporte Comentarios</a>
                        </li>
                    @endif       

                        @if(Auth::user()->role == 'admin' )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">Lista de Usuarios</a>
                            </li>
                        @endif

                        @if(Auth::user()->role == 'admin' )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('category') }}">Lista de Categorias</a>
                            </li>
                        @endif

                        @if(Auth::user()->role == 'user' )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Inicio</a>   
                            </li>
                        @endif

                        @if(Auth::user()->role == 'user' )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">Comunidad</a>   
                            </li>
                        @endif
                        
                        @if(Auth::user()->role == 'user' )
                        <li class="nav-item">    
                            <a class="nav-link" href="{{ route('image.create') }}">Subir Imagen</a>
                        </li>
                        @endif
                        
                        <li>
                            @include('includes.profile_image')                  
                        </li>
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nick }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role == 'user' )
                                    <a class="dropdown-item" href="{{ route('user.profile', ['id' => Auth::user()-> id]) }}">
                                        Mi perfil
                                    </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('config') }}">
                                        Configuración
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
