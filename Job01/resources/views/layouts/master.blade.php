<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Default Title')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.min.css') }}">
</head>

<body>

  <header>
    @include('layouts.header')
  </header>

  <main>
    @yield('content')
  </main>

  <footer>
    @include('layouts.footer')
  </footer>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
</body>

</html>