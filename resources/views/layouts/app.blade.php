<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Whoray') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') . '?20220209' }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') . '?20220209' }}" rel="stylesheet">

    <!-- Icon設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
    <div id="app">
        <header id="app-header" class="fixed-top">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Whoray') }}
                    </a>
                </div>
            </--nav>
            @guest
                <slide id="burger-menu" right>
                    <a class="nav-link" href="{{ route('login') }}">
                        <span>{{ __('login.login') }}</span>
                    </a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">
                            <span>{{ __('login.register') }}</span>
                        </a>
                    @endif
                </slide>
            @else
                <slide id="burger-menu" right>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <span>{{ __('login.logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </slide>
            @endguest
        </header>

        <main class="pt-3 pb-4">
            <div class="mt-5 mb-5">
                @yield('content')
            </div>
        </main>

        @auth
            <footer class="fixed-bottom">
                <nav class="f-global-nav">
                    <ul class="nav-list" style="height:60px;">
                        <li class="nav-item">
                            <a href="/home">
                                <i class="fa fa-comments fa-2x"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dailyaction">
                                <i class="fa fa-cubes fa-2x"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/okrasetting">
                                <i class="fa fa-cogs fa-2x"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href='/mypage?id={{Auth::id()}}'>
                                <i class="fa fa-user fa-2x"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </footer>
        @endauth
    </div>
</body>
</html>
