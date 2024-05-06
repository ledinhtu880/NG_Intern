<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.contextMenu.css" rel="stylesheet"
        type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&display=swap"
        rel="stylesheet">
    @stack('css')
</head>

<body>
    @if (session('name'))
        <main>
            <div class="container-fluid g-0">
                <div class="row g-0">
                    <div class="col-md-12">
                        <header>
                            @include('layouts.header')
                        </header>
                    </div>
                    <div class="col-md-12">
                        <div class="spacer"></div>
                    </div>
                </div>
            </div>
            <div class="container-fluid g-0">
                <div class="row g-0">
                    <div class="col-md-2">
                        <nav class="vh-100" style="border-right: 1px solid rgb(224, 224, 224) !important;">
                            @include('layouts.sidebar')
                        </nav>
                    </div>
                    <div class="col-md-10">
                        <div class="content-wr er d-flex flex-column h-100">
                            <article class="flex-grow-1 px-3">
                                @yield('content')
                            </article>
                            <footer>
                                @include('layouts.footer')
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @else
        <div class="d-flex align-items-center justify-content-center vh-100">
            @yield('content')
        </div>
    @endif

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.contextMenu.js" type="text/javascript"></script>
    <script src="https://swisnl.github.io/jQuery-contextMenu/dist/jquery.ui.position.min.js" type="text/javascript">
    </script>
    @stack('javascript')
</body>

</html>
