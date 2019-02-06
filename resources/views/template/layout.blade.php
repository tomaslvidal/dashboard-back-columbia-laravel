<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="{{ asset('css/app.css?v='.filemtime(public_path('css/app.css'))) }}" rel="stylesheet">

        <link href="{{ asset('css/style.css?v='.filemtime(public_path('css/style.css'))) }}" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <link rel="shortcut icon" href="{{ asset('img/favicon.ico?v='.filemtime(public_path('img/favicon.ico'))) }}">

        @yield('style')
    </head>

    <body>
        <div class="app">            
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js?v='.filemtime(public_path('js/app.js'))) }}"></script>

        @yield('script')
    </body>
</html>