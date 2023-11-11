<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand pt-0" href="#">
      <img src="{{ asset('images/logo.jpg')}}" alt="Logo" class="object-fit-cover" height="50">
    </a>
    @if(Auth::check() == false)
    <div>
      <button type="button" class="btn text-primary-color" data-bs-toggle="modal" data-bs-target="#userModal">
        Đăng nhập
      </button>
      <button type="button" class="btn text-primary-color" data-bs-toggle="modal" data-bs-target="#signUpModal">
        Đăng ký
      </button>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h1 class="fs-4 text-center mb-4" id="userModalLabel" style="margin-top: -48px;">Đăng nhập</h1>
            <form method="post" action="{{ route('login') }}">
              @csrf
              <div class="form-floating mb-3">
                <input name="email" type="username" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                  id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email</label>
                @if($errors->has('email'))
                <span class="text-danger">
                  {{ $errors->first('email') }}
                </span>
                @endif
              </div>
              <div class="form-floating mb-3">
                <input name="password" type="password"
                  class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="floatingPassword"
                  placeholder="Password">
                <label for="floatingPassword">Password</label>
                <span class="text-danger">
                  {{ $errors->first('password') }}
                </span>
              </div>
              <div class="form-group mb-3 text-center">
                <a href="#" class="text-primary-color text-decoration-none">Quên mật khẩu?</a>
              </div>
              <div class="form-group mb-3">
                <button type="submit" class="btn btn-lg btn-primary-color w-100">Đăng nhập</button>
              </div>
            </form>
            <div class="d-flex align-items-center justify-content-center">
              <span>Bạn chưa có tài khoản?</span>
              <button class="btn ms-2 p-0 text-primary-color" data-bs-target="#signUpModal" data-bs-toggle="modal">
                Đăng ký
              </button>
            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex align-items-center justify-content-center gap-4">
              <button type="button" class="btn btn-primary-color">Tiếng Anh</button>
              <button type="button" class="btn btn-primary-color">Tiếng Việt</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="signUpModal" aria-hidden="true" aria-labelledby="signUpModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h1 class="fs-4 text-center mb-4" id="userModalLabel" style="margin-top: -48px;">Đăng ký</h1>
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-floating mb-3">
                <input name="r_name" type="text" class="form-control{{ $errors->has('r_name') ? ' is-invalid' : '' }}"
                  id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Username</label>
                @if($errors->has('r_name'))
                <span class="text-danger">
                  {{ $errors->first('r_name') }}
                </span>
                @endif
              </div>
              <div class="form-floating mb-3">
                <input name="r_email" type="email"
                  class="form-control{{ $errors->has('r_email') ? ' is-invalid' : '' }}" id="floatingInput"
                  placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                @if($errors->has('r_email'))
                <span class="text-danger">
                  {{ $errors->first('r_email') }}
                </span>
                @endif
              </div>
              <div class="form-floating mb-3">
                <input name="r_password" type="password"
                  class="form-control{{ $errors->has('r_password') ? ' is-invalid' : '' }}" id="floatingPassword"
                  placeholder="Password">
                <label for="floatingPassword">Password</label>
                @if($errors->has('r_password'))
                <span class="text-danger">
                  {{ $errors->first('r_password') }}
                </span>
                @endif
              </div>
              <div class="form-floating mb-3">
                <input name="confirm_password" type="password"
                  class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                  id="floating_ConfirmPassword" placeholder="Confirm password">
                <label for="floating_ConfirmPassword">Confirm password</label>
                @if($errors->has('confirm_password'))
                <span class="text-danger">
                  {{ $errors->first('confirm_password') }}
                </span>
                @endif
              </div>
              <div class="form-group mb-3">
                <button type="submit" class="btn btn-lg btn-primary-color w-100">Đăng ký</button>
              </div>
            </form>
            <div class="d-flex align-items-center justify-content-center">
              <span>Đã có tài khoản rồi?</span>
              <button class="btn ms-2 p-0 text-primary-color" data-bs-toggle="modal" data-bs-target="#userModal">Đăng
                nhập</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="d-flex align-items-center justify-content-center gap-5">
      <p class="m-0 text-primary-color">Xin chào {{ session('name') }}</p>
      <a href="{{ route('logout') }}" class="btn text-primary-color">
        Đăng xuất
      </a>
    </div>
    @endif
  </div>
</nav>