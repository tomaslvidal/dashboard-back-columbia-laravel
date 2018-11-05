<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('img/favicon.ico?v='.filemtime(public_path('img/favicon.ico'))) }}">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>

            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            </ul>

            <div class="navbar-collapse justify-content-end">
                <div class="navbar-nav align-items-center">
                    <span class="navbar-nav nav-link">Login</a></span>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    </body>
</html>
