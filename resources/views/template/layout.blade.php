<!DOCTYPE html>

    <html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | @yield('title') </title>

        <link href="{{ asset('css/app.css?v='.filemtime(public_path('css/app.css')) ) }}" rel="stylesheet">

        <link href="{{ asset('css/style.css?v='.filemtime(public_path('css/style.css')) ) }}" rel="stylesheet">

        <?php
        /*<script>
            window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
        </script>*/
        ?>

        @yield('style')
    </head>

    {{-- <body> --}}
    <body>
        <div class="app">            
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js?v='.filemtime(public_path('js/app.js'))) }}"></script>

        <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="{{ asset('js/ckeditor/ckeditor.js?v='.filemtime(public_path('js/ckeditor/ckeditor.js'))) }}"></script>

        @yield('script')
    </body>
</html>