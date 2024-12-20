@extends('layouts.master')

@section('title', 'Đăng nhập')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-4">
                <div class="card shadow rounded-1">
                    <div class="card-header d-flex align-items-center justify-content-center py-3">
                        <a href="{{ route('index') }}" class="text-center">
                            <img src="{{ asset('images/nobg.png') }}" alt="" height="64" class="object-fit-cover">
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h4 class="text-dark-emphasis text-center pb-0 fs-5 fw-bold">Đăng nhập</h4>
                            <p class="text-muted mb-4">Nhập tên đăng nhập và mật khẩu của bạn</p>
                        </div>
                        <form action="{{ route('checkLogin') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary" for="floatingInput">Tên đăng nhập</label>
                                <input name="username" type="username"
                                    class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                    id="floatingInput" placeholder="Vui lòng nhập tên đăng nhập" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('username'))
                                        {{ $errors->first('username') }}
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary" for="floatingPassword">Password</label>
                                <input name="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="floatingPassword" placeholder="Vui lòng nhập mật khẩu" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('password'))
                                        {{ $errors->first('password') }}
                                    @endif
                                </span>
                            </div>
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary rounded-1" tabindex="3">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@if (session('message') && session('type'))
    <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    @if (session('type') == 'success')
                        <i class="fas fa-check-circle text-light fs-5"></i>
                    @elseif(session('type') == 'danger' || session('type') == 'warning')
                        <i class="fas fa-xmark-circle text-light fs-5"></i>
                    @elseif(session('type') == 'info' || session('type') == 'secondary')
                        <i class="fas fa-info-circle text-light fs-5"></i>
                    @endif
                    <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const toastLiveExample = $('#liveToast');
        const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
        toastBootstrap.show();
    </script>
@endpush
