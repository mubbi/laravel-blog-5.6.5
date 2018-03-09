<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Update your html tag to include the itemscope and itemtype attributes. -->
    <html itemscope itemtype="http://schema.org/Article">

    <!-- SEO Title -->
    <title>@yield('pageTitle', app('global_settings')[0]['setting_value'].' - '.app('global_settings')[1]['setting_value'])</title>

    <!-- SEO Meta Descrition -->
    <meta name="description" content="@yield('pageDescription', app('global_settings')[1]['setting_value'])">

    <!-- Social Meta Tags -->

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="@yield('pageTitle', app('global_settings')[0]['setting_value'].' - '.app('global_settings')[1]['setting_value'])">
    <meta itemprop="description" content="@yield('pageDescription', app('global_settings')[1]['setting_value'])">
    <meta itemprop="image" content="http://www.example.com/image.jpg">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('pageTitle', app('global_settings')[0]['setting_value'].' - '.app('global_settings')[1]['setting_value'])">
    <meta name="twitter:description" content="@yield('pageDescription', app('global_settings')[1]['setting_value'])">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="http://www.example.com/image.jpg">

    <!-- Open Graph data -->
    <meta property="og:title" content="@yield('pageTitle', app('global_settings')[0]['setting_value'].' - '.app('global_settings')[1]['setting_value'])" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:image" content="@yield('pageImage', 'http://placehold.it/700x700')" />
    <meta property="og:description" content="@yield('pageDescription', app('global_settings')[1]['setting_value'])" />
    <meta property="og:site_name" content="{{ app('global_settings')[0]['setting_value'] }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    @yield('custom_css')
     <script>
        var base_url = "{{ url('') }}";
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ app('global_settings')[0]['setting_value'] }} - <small>{{ app('global_settings')[1]['setting_value'] }}</small>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ route('blogs.index') }}">Manage blogs</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('includes.errors')
                        @include('includes.success')
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                    <div class="col-md-4">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </main>

        <footer>
            @include('includes.footer')
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('custom_js')

</body>
</html>
