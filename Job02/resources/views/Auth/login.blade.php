@extends('layouts.master')

@section('content')
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h1 class="fs-4 text-center mb-4" id="userModalLabel" style="margin-top: -48px;">Đăng nhập</h1>
        <form method="post" route="{{ route('login') }}">
          @csrf
          <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
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
    </div>
  </div>
</div>
@endsection