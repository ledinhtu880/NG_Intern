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
    <div class="container mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="">Theo dõi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Theo dõi đơn hàng nội bộ</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="w-25">
                    <div class="input-group">
                        <label for="" class="input-group-text bg-primary-color p-2">Đơn hàng</label>
                        <select name="" id="orderlocal_type" class="form-select">
                            <option value="0">Sản xuất</option>
                            <option value="1">Đóng gói</option>
                            <option value="2">Giao hàng</option>
                        </select>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header p-0 overflow-hidden">
                        <h4 class="card-title m-0 bg-primary-color p-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-list-ul fs-6"></i>
                            Bảng đơn hàng nội bộ
                        </h4>
                    </div>
                    <div class="card-body ">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Mã đơn hàng</th>
                                    <th class="text-center">Kiểu hàng</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Ngày bắt đầu</th>
                                    <th class="text-center">Ngày giao hàng</th>
                                    <th class="text-center">Ngày hoàn thành</th>
                                    <th class="text-center">Xem</th>
                                </tr>
                            </thead>
                            <tbody class="order-infor">
                            </tbody>
                        </table>
                    </div>
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
