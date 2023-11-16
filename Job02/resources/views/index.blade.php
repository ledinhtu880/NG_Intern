@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
<div class="container-fluid g-0">
  <div class="row g-0">
    <div class="col-md-12 g-0">
      <div class="tabs d-flex justify-content-between">
        <div class="tab-item active">
          <h6>Quản lý</h6>
        </div>
        <div class="tab-item">
          <h6>Theo dõi</h6>
        </div>
        <div class="tab-item">
          <h6>Quản trị hệ thống</h6>
        </div>
        <div class="tabs-line"></div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-3">
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content">
        <div class="tab-pane active">
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex flex-column">
                <a href="{{ route('orders.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý đơn hàng</a>
                <a href="{{ route('customers.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý khách hàng</a>
                <a href="{{ route('rawMaterials.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý nguyên
                  liệu</a>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <h2 class="h2 text-primary-color">Quản lý sản xuất và giao hàng</h2>
            </div>
          </div>
        </div>
        <div class="tab-pane">
        </div>
        <div class="tab-pane">
        </div>
      </div>
    </div>
  </div>
</div>
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
@endsection

@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
@endpush