<!doctype html>
<html lang="en">

    <head>
        @include('layouts.inc.head')
    </head>

    <body class="d-flex flex-column h-100">
        <header>
            @include('layouts.inc.header')
        </header>
        <!-- Begin page content -->
        <main role="main" class="container">
            @yield('content')
        </main>

        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        @stack('script');

    </body>
</html>