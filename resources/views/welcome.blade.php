<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        {{-- <script>window.Laravel = { csrfToken: 'csrf_token()' }</script> --}}

        <title>Laravel Sample</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <articles></articles>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
