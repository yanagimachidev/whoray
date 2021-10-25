<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Whoray') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header id="app-header" class="fixed-top">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Whoray') }}
                    </a>
                </div>
            </nav>
            @guest
                <slide id="burger-menu" right>
                    <a class="nav-link" href="{{ route('login') }}">
                        <span>{{ __('Login') }}</span>
                    </a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">
                            <span>{{ __('Register') }}</span>
                        </a>
                    @endif
                </slide>
            @else
                <slide id="burger-menu" right>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <span>{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </slide>
            @endguest
        </header>

        <main class="py-3">
            <div class="mt-5"></div>
            @yield('content')
            <div class="mb-5"></div>
        </main>

        @auth
            <footer class="fixed-bottom">
                <nav class="f-global-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="/home">
                                <i class="fas fa-history"></i>
                                <span>タイムライン</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dailyaction">
                                <i class="fas fa-history"></i>
                                <span>日々の積み上げ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/okrasetting">
                                <i class="fas fa-history"></i>
                                <span>目的・目標・アクション管理</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/mypage">
                                <i class="fas fa-history"></i>
                                <span>マイページ</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </footer>
        @endauth
    </div>
</body>
</html>
