@extends('layouts.master')

@section('title', @isset($user) ? 'Sửa người dùng' : 'Thêm người dùng mới')
@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý người dùng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('users.index') }}">Quản lý người
                        dùng</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">
                        @if (isset($user))
                            Sửa người dùng
                        @else
                            Thêm người dùng mới
                        @endif
                        </h5>
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
                                    <i class="fa-solid fa-user text-primary"></i>
                                    Tên người dùng<span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}"
                                    id="name" name="Name" placeholder="Nhập tên người dùng"
                                    value="{{ $user->Name ?? old('Name') }}">
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
                                    <i class="fa-solid fa-circle-user text-primary"></i>
                                    Tài khoản<span style="color: red;">*</span>
                                </label>
                                <input type="text"
                                    class="form-control{{ $errors->has('UserName') ? ' is-invalid' : '' }}" id="username"
                                    name="UserName" placeholder="Nhập tài khoản"
                                    value="{{ $user->UserName ?? old('UserName') }}">
                            </div>
                            @if ($errors->has('UserName'))
                                <div class="text-danger">
                                    {{ $errors->first('UserName') }}
                                </div>
                            @endif
                        </div>
                        @if (!isset($user))
                            <div class="mb-3">
                                <div class="input-group">
                                    <label for="password" class="input-group-text d-flex align-items-center gap-1">
                                        <i class="fa-solid fa-lock text-primary"></i>
                                        Mật khẩu<span style="color: red;">*</span>
                                    </label>
                                    <input type="password"
                                        class="form-control{{ $errors->has('Password') ? ' is-invalid' : '' }}"
                                        id="password" name="Password" placeholder="Nhập mật khẩu">
                                </div>
                                @if ($errors->has('Password'))
                                    <div class="text-danger">
                                        {{ $errors->first('Password') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('users.index') }}" class="btn btn-light">
                                Quay lại
                            </a>
                            <button class="btn btn-primary" type="submit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
