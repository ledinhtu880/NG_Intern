@extends('layouts.master')

@section('title', 'Xem chi tiết trạm')
@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
      <div class="card border-0 shadow overflow-hidden" style="width: 650px">
        <div class="row g-0">
          <div class="card-header bg-primary-color">
            <h4 class="h4 card-title text-white pt-2">Thông tin dây chuyền sản xuất</h4>
          </div>
          <div class="card-body d-flex flex-column justify-content-between h-100">
            <div class="row">
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Tên dây chuyền</h5>
                <h6 class="h6 text-muted">{{ $productStationLine->Name_ProdStationLine }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Tên trạm</h5>
                {{-- <h6 class="h6 text-muted fw-normal m-0">{{ $station->Name_Station }}</h6> --}}
                <div class="row">
                  @foreach ($detailProductionStationLines as $item)
                  <div class="col-md-6">
                    <h6 class="h6 text-muted ">{{ $item->station->Name_Station }}</h6>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Mô tả</h5>
                <h6 class="h6 text-muted">{{ $productStationLine->Description }}</h6>
              </div>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Loại</h5>
                <h6 class="h6 text-muted">{{ $productStationLine->orderType->Name_OrderType }}</h6>
              </div>
              {{-- <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Địa chỉ IP</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $station->Ip_Address }}</h6>
              </div>
            </div>
            <div class="row">
              <h5 class="h5 fw-medium mb-1">Tên loại trạm</h5>
              <h6 class="h6 text-muted fw-normal m-0">{{ $station->stationType->Name_StationType }}</h6>
            </div> --}}
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-end align-items-center gap-2">
                  <a href="{{ route('productStationLines.index') }}" class="btn btn-warning">Quay lại</a>
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

@push('javascript')
<script>
  $(document).ready(function () {
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })
</script>
@endpush