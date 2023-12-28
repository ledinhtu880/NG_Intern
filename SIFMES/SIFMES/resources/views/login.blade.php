@extends('layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="container-fluid border border-dark-subtle w-25 border-0">
    <div class="card">
        <div class="card-header d-flex align-items-center" style="background-color: #2b4c72">
            <h4 class="card-title m-0 bg-primary-color py-2">Đăng nhập</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('checkLogin') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input name="username" type="username" class="form-control" id="floatingInput"
                        placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-group mb-3 text-center">
                    <a href="#" class="text-primary-color text-decoration-none">Quên mật khẩu?</a>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary-color w-100">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@if(session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
            <div class="d-flex justify-content-center align-items-center gap-2">
                @if(session('type') == 'success')
                <i class="fas fa-check-circle text-light fs-5"></i>
                @elseif(session('type') == 'danger' || session('type') == 'warning')
                <i class="fas fa-xmark-circle text-light fs-5"></i>
                @elseif(session('type') == 'info' || session('type') == 'secondary')
                <i class="fas fa-info-circle text-light fs-5"></i>
                @endif
                <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@push('javascript')
<script>
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
</script>
@endpush