@extends('layouts.master')

@section('title', 'Tạo đơn đóng gói')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.packs.index') }}">Quản lý đơn đóng gói</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Tạo đơn đóng gói</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Gói hàng</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="input-group" style="width: 350px;">
                            <label class="input-group-text bg-secondary-subtle" for="FK_Id_CustomerType">
                                Loại khách hàng
                            </label>
                            <select name="FK_Id_CustomerType" id="FK_Id_CustomerType" class="form-select" tabindex="1">
                                @foreach ($customerType as $each)
                                    <option value="{{ $each->Id }}">{{ $each->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover m-0">
                            <thead class="table-heading">
                                <tr class="align-middle">
                                    <th scope="col" class="py-2 text-center">Chọn</th>
                                    <th scope="col" class="py-2 text-center">Mã gói hàng</th>
                                    <th scope="col" class="py-2 text-center">Mã đơn hàng</th>
                                    <th scope="col" class="py-2">Khách hàng</th>
                                    <th scope="col" class="py-2 text-center">Số lượng gói hàng</th>
                                    <th scope="col" class="py-2 text-center">Giá gói hàng</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-content-center justify-content-between">
                        <button type="submit" class="btn btn-primary px-3" id="addBtn" tabindex="3">
                            <i class="fa-solid fa-plus text-white me-2"></i>Thêm
                        </button>
                        <div class="input-group" style="width: 300px;">
                            <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                                Ngày giao hàng
                            </label>
                            <input type="date" name="Date_Delivery" id="Date_Delivery" class="form-control"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" tabindex="2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Đơn đóng gói</h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">Chọn</th>
                                <th scope="col" class="py-2 text-center">Mã đơn hàng</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2">Kiểu hàng</th>
                                <th scope="col" class="py-2 text-center">Ngày giao hàng</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-result">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-between">
                        <button type="submit" class="btn btn-primary px-3" id="deleteBtn" tabindex="4">
                            <i class="fa-solid fa-minus text-white me-2"></i>Xóa
                        </button>
                        <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-secondary" tabindex="5">Quay
                            lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center justify-content-between">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <i id="icon" class="fas text-light fs-5"></i>
                    <h6 id="toast-msg" class="h6 text-white m-0"></h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection


@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/orderLocals/packs/create.js') }}"></script>
@endpush
