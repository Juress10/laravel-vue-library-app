<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .navbar-menu{
            width:100% !important;
        }
        h1{
            margin:0;
        }
        .bg-nonactive{
            background-color: rgba(238, 238, 238, 0.76);
        }
        .text-active{
            color: #999999;
            font-family: 'Lato', sans-serif;
        }
        .text-nonactive{
            color: #757575;;
            font-family: 'Lato', sans-serif;
        }
        a:hover{
            color: rgb(148, 208, 187);
            text-decoration: none;
        }
        .no-padding{
            padding:0px;
        }
        .divider{
            border-right: 1px solid rgba(0,0,0,0.1);
        }
    </style>

</head>
<body>

    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm no-padding">
            <div class=" navbar-menu row">
                <a class="col-6 {{ Request::is('books') || Request::is('/') ? ' text-nonactive' : 'bg-nonactive text-active' }} d-flex justify-content-center divider" href="/books"><h1>Books</h1></a>
                <a class="col-6 {{ Request::is('authors') ? 'text-nonactive' : 'bg-nonactive text-active' }} d-flex justify-content-center" href="/authors"><h1>Authors</h1></a>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
