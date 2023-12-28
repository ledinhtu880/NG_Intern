@extends('layouts.master')

@section('title', @isset($user) ? 'Sửa người dùng' : 'Thêm người dùng mới')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a href="{{ route('users.index') }}" class="text-decoration-none">Quản lý người dùng</a>
            </li>
            @if (isset($user))
              <li class="breadcrumb-item active">Sửa người dùng</li>
            @else
              <li class="breadcrumb-item active">Thêm người dùng mới</li>
            @endif
          </ol>
        </nav>
        <div class="card mt-3">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">
              @if (isset($user))
                Sửa người dùng
              @else
                Thêm người dùng mới
              @endif
            </h4>
          </div>
          <div class="card-body">
            <form
              action="@if (isset($user)) {{ route('users.update', compact('user')) }} @else {{ route('users.store') }} @endif"
              method="POST">
              @csrf
              @if (isset($user))
                @method('PUT')
              @endif
              <div class="mb-3">
                <div class="input-group">
                  <label for="name" class="input-group-text d-flex align-items-center gap-1">
                    <i class="fa-solid fa-user text-primary-color"></i>
                    Tên người dùng<span style="color: red;">*</span>
                  </label>
                  <input type="text" class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}" id="name"
                    name="Name" placeholder="Nhập tên người dùng" value="{{ $user->Name ?? old('Name') }}">
                </div>
                @if ($errors->has('Name'))
                  <div class="text-danger">
                    {{ $errors->first('Name') }}
                  </div>
                @endif
              </div>
              <div class="mb-3">
                <div class="input-group">
                  <label for="username" class="input-group-text d-flex align-items-center gap-1">
                    <i class="fa-solid fa-circle-user text-primary-color"></i>
                    Tài khoản<span style="color: red;">*</span>
                  </label>
                  <input type="text" class="form-control{{ $errors->has('UserName') ? ' is-invalid' : '' }}"
                    id="username" name="UserName" placeholder="Nhập tài khoản"
                    value="{{ $user->UserName ?? old('UserName') }}">
                </div>
                @if ($errors->has('UserName'))
                  <div class="text-danger">
                    {{ $errors->first('UserName') }}
                  </div>
                @endif
              </div>
              <div class="mb-3">
                <div class="input-group">
                  <label for="password" class="input-group-text d-flex align-items-center gap-1">
                    <i class="fa-solid fa-lock text-primary-color"></i>
                    Mật khẩu<span style="color: red;">*</span>
                  </label>
                  <input type="password" class="form-control{{ $errors->has('Password') ? ' is-invalid' : '' }}"
                    id="password" name="Password" placeholder="Nhập mật khẩu">
                </div>
                @if ($errors->has('Password'))
                  <div class="text-danger">
                    {{ $errors->first('Password') }}
                  </div>
                @endif
              </div>
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary-color me-2" type="submit">Lưu</button>
                <a href="{{ route('users.index') }}" class="btn btn-warning">
                  <i class="fa-solid fa-arrow-left"></i>
                  Hủy
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
