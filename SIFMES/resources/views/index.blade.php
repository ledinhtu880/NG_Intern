@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
<div class="container mt-3">
  <div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
      <div class="wrapper w-75">
        <div class="d-flex justify-content-center align-items-center">
          <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <a href="{{ route('customers.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lí <br> khách hàng</span>
            </a>
          </div>
          <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <a href="{{ route('roles.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lí vai trò</span>
            </a>
            <a href="{{ route('orders.simples.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Quản lí đơn <br>thùng hàng</span>
            </a>
            <a href="{{ route('orderLocals.makes.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Quản lí đơn <br> sản xuất</span>
            </a>
            <a href="{{ route('wares.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lý kho hàng</span>
            </a>
          </div>
          <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <a href="{{ route('tracking.orders.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Theo dõi đơn hàng</span>
            </a>
            <a href="{{ route('index') }}" class="hexagon hexagon-main text-decoration-none p-3">
              <img src="{{ asset('images/nobg.png') }}" class="object-fit-contain w-100 h-100">
            </a>
            <a href="{{ route('orderLocals.packs.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Quản lí đơn <br> đóng gói</span>
            </a>
          </div>
          <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <a href="{{ route('users.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lí <br> người dùng</span>
            </a>
            <a href="{{ route('orders.packs.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Quản lí đơn <br> gói hàng</span>
            </a>
            <a href="{{ route('orderLocals.makes.index') }}" class="hexagon hexagon-secondary text-decoration-none">
              <span>Quản lí đơn <br> giao hàng</span>
            </a>
            <a href="{{ route('stations.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lý trạm</span>
            </a>
          </div>
          <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <a href="{{ route('rawMaterials.index') }}" class="hexagon hexagon-outline text-decoration-none">
              <span>Quản lí <br> nguyên liệu</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@if (session('message') && session('type'))
<div class=" toast-container rounded position-fixed bottom-0 end-0 p-3">
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

@push('javascript')
<script type="text/javascript">
  $(document).ready(function () {
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })
</script>
@endpush