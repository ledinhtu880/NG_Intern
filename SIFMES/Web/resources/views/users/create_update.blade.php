@extends('layouts.master')

@section('title', @isset($user) ? 'Sửa người dùng' : 'Thêm người dùng mới')
@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('users.index') }}">Quản lý người
                    dùng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">
                {{ isset($user) ? 'Sửa' : 'Thêm' }}
            </li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            {{ isset($user) ? 'Sửa người dùng' : 'Thêm người dùng' }}
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">
                        Thông tin người dùng
                    </h5>
                    <form
                        action="@if (isset($user)) {{ route('users.update', compact('user')) }} @else {{ route('users.store') }} @endif"
                        method="POST">
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="Name" class="form-label">
                                    Tên người dùng
                                </label>
                                <input type="text" class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}"
                                    id="Name" name="Name" placeholder="Nhập tên người dùng"
                                    value="{{ $user->Name ?? old('Name') }}">
                            </div>
                            @if ($errors->has('Name'))
                                <div class="text-danger">
                                    {{ $errors->first('Name') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="UserName" class="form-label">
                                    Tên đăng nhập
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
                                <div class="form-group">
                                    <label for="password" class="form-label">Mật khẩu</label>
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
                            <button class="btn btn-primary" type="submit">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
