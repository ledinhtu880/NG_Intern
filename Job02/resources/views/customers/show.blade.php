@extends('layouts.master')

@section('title', 'Xem chi tiết khách hàng')

@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
      <div class="card border-0 shadow overflow-hidden" style="width: 650px">
        <div class="row g-0">
          <div class="card-body d-flex flex-column justify-content-between h-100">
            <div class="row">
              <h4 class="h4 card-title border-bottom mb-3">Thông tin khách hàng</h4>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Tên khách hàng</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->Name_Customer }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Tên liên hệ</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->Name_Contact }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Email</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->Email }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Số điện thoại</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->Phone }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Địa chỉ</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->Address }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Zipcode</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $customer->ZipCode }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Thời gian tạo tài khoản</h5>
                <h6 class="h6 text-muted fw-normal m-0">
                  @php
                  \Carbon\Carbon::setLocale('vi');
                  @endphp
                  {{ \Carbon\Carbon::parse($customer->Time_Reception)->diffForHumans() }}
                </h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-end align-items-center gap-2">
                  <a href="{{ route('customers.index') }}" class="btn btn-warning">Quay lại</a>
                </div>
              </div>
            </div>
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
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@endsection