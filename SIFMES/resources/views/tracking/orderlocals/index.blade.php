@extends('layouts.master')

@section('title', 'Theo dõi đơn hàng nội bộ')

@push('css')
<style>
    .progress-text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endpush

@section('content')
<div class="row g-0 p-3">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="h4 m-0 fw-bold text-body-secondary">Theo dõi đơn hàng nội bộ</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi đơn hàng nội bộ</li>
        </ol>
    </div>
</div>
<div class="row g-0 p-3">
    <div class="col-md-12">
        <div class="w-25 mb-4">
            <div class="input-group">
                <label for="" class="input-group-text p-2">Đơn hàng</label>
                <select name="" id="orderlocal_type" class="form-select">
                    <option value="0">Sản xuất</option>
                    <option value="1">Đóng gói</option>
                    <option value="2">Giao hàng</option>
                </select>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-white">
                <h5 class="card-title m-0 fw-bold text-body-secondary">
                    <i class="fa-solid fa-list-ul me-3"></i>
                    Bảng đơn hàng nội bộ
                </h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3 text-center">Mã đơn hàng</th>
                            <th scope="col" class="py-3 text-center">Kiểu hàng</th>
                            <th scope="col" class="py-3 text-center">Số lượng</th>
                            <th scope="col" class="py-3 text-center">Ngày bắt đầu</th>
                            <th scope="col" class="py-3 text-center">Ngày giao hàng</th>
                            <th scope="col" class="py-3 text-center">Ngày hoàn thành</th>
                            <th scope="col" class="py-3 text-center">Xem</th>
                        </tr>
                    </thead>
                    <tbody class="order-infor">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script></script>
<script type="text/javascript" src="{{ asset('js/tracking/InforOrderlocal.js') }}"></script>
@endpush