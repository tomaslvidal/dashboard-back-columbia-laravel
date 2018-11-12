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

        <link rel="shortcut icon" href="{{ asset('img/favicon.ico?v='.filemtime(public_path('img/favicon.ico'))) }}">

        @yield('style')
    </head>

    <body>
        <div class="app">            
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js?v='.filemtime(public_path('js/app.js'))) }}"></script>

        <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>

        @yield('script')
    </body>
</html>