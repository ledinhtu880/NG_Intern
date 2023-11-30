<nav class="navbar mb-3">
  <div class="container-fluid">
    <a class="navbar-brand pt-0" href="{{ route('index') }}">
      <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="object-fit-cover" height="50">
    </a>
    @if (session('name'))
    <div class="d-flex align-items-center justify-content-center gap-2">
      <p class="m-0 text-primary-color">Xin chào {{ session('name') }}</p>
      <a href="{{ route('logout') }}" class="btn text-primary-color">
        Đăng xuất
      </a>
    </div>
    @else
    <a href="{{ route('login') }}" class="btn text-primary-color">Đăng nhập</a>
    @endif

  </div>
</nav>