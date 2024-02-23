@extends('layouts.master')

@section('title', 'Xem chi tiết khách hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin khách hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('customers.index') }}">Quản lý khách hàng</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Mã khách hàng</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Id_Customer }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Tên khách hàng</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Name_Customer }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Tên liên hệ</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Name_Contact }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Email</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Email }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Số điện thoại</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Phone }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Địa chỉ</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->Address }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Zipcode</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->ZipCode }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Thời gian nhận</h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $customer->Time_Reception }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Kiểu khách hàng</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->customerType->Name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">Phương thức vận chuyển</h6>
                            <p class="card-text text-secondary fw-normal">{{ $customer->types->Name_ModeTransport }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('customers.index') }}" class="btn btn-light">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('message') && session('type'))
        <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
                    <div class=" d-flex justify-content-center align-items-center gap-2">
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
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            const toastLiveExample = $('#liveToast');
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            toastBootstrap.show();
        })
    </script>
@endpush
