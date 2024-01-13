@extends('layouts.master')

@section('title', 'Sửa đơn giao hàng')

@section('content')
<div class="row g-0 p-3">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin giao hàng</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn giao hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
</div>
<div class="row g-0 p-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header border-0 bg-white">
                <h5 class="card-title m-0 fw-bold text-body-secondary">Sửa thông tin đơn giao hàng</h5>
            </div>
            <div class="card-body">
                <form action="{{route('orderLocals.expeditions.update', $orderLocal->Id_OrderLocal)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="" class="input-group-text">Mã đơn giao hàng</label>
                                <input type="text" name='Id_OrderLocal' class="form-control " readonly disabled
                                    value="{{ $orderLocal->Id_OrderLocal }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="" class="input-group-text">Ngày giao hàng</label>
                                <input type="date" class="form-control" name="Date_Delivery"
                                    value="{{ Carbon\Carbon::parse($orderLocal->Date_Delivery)->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="" class="input-group-text">Ngày bắt đầu</label>
                                <input type="date" class="form-control " name="Date_Start"
                                    value="{{ Carbon\Carbon::parse($orderLocal->Date_Start)->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="" class="input-group-text">Số lượng</label>
                                <input type="number" min='1' class="form-control" name="Count"
                                    value="{{ $orderLocal->Count }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center justify-content-end gap-3">
                        <a href="{{ route('orderLocals.expeditions.index') }}" class="btn btn-light">Quay lại</a>
                        <button type="submit" class="btn btn-primary px-4">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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