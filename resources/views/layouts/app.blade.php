<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="robots" content="ALL" />
    <meta name="description" content="クラウドファンディングで得たモノを共有したい" />
    <meta name="keywords" content="Crowdfunding,review,share,クラウドファンディング,レビュー,共有" />
    <meta property="og:title" content="プロジェクト一覧">
    <meta property="og:description" content="クラウドファンディングで 得たモノ を共有したい！">
    <meta property="og:site_name" content="Crowdfunding Reviews(クラウドファンディングレビュー)">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{config('app.url')}}/image/og_image.png" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@filler45">
    <meta property="og:url" content="{{config('app.url')}}" />

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><router-link :to="{name: 'about'}" class="btn btn-link">about</router-link></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li><router-link class="btn btn-primary btn-sm" :to="{name: 'project-new'}">New Project</router-link></li>

                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container" style="margin-top: 20px; margin-bottom: 20px;">
            @yield('content')
        </main>

        <footer class="footer mt-auto py-3 container" style="border-top: 1px solid #ccc;">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div><router-link :to="{name:'top'}" class="btn btn-link">Project List</router-link></div>
                    <div><router-link class="btn btn-link" :to="{name: 'project-new'}">Create New Project</router-link></div>
                    <div><router-link :to="{name: 'about'}" class="btn btn-link">About This Site</router-link></div>
                </div>
            </div>
            <div class="text-right">
                <span class="text-muted">Copyright &copy; 2019 takemitsu.net All right reserved.</span>
            </div>
        </footer>

    </div>
</body>
</html>
