@extends('layouts.master')

@section('title', 'Xem chi tiết đơn sản xuất')
@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Thông tin đơn sản xuất</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Mã đơn hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->Id_OrderLocal }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Số lượng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->Count }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Kiểu hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->type }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Trạng thái
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->status }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày giao hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->delivery_date }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày bắt đầu
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->start_date }}
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày kết thúc
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $orderLocal->finally_date }}
                            </p>
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
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chi tiết</h5>
                    <table class="table table-borderless table-hover m-0 mb-3">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Nguyên liệu</th>
                                <th scope="col" class="py-2 text-center">Số lượng nguyên liệu</th>
                                <th scope="col" class="py-2">Đơn vị</th>
                                <th scope="col" class="py-2">Thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Số lượng thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Đơn giá thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <tr class="align-middle">
                                    <th scope="row" class="text-center text-body-secondary">{{ $each->Id_ContentSimple }}
                                    </th>
                                    <td>{{ $each->Name_RawMaterial }}</td>
                                    <td class="text-center">{{ $each->Count_RawMaterial }}</td>
                                    <td>{{ $each->Unit }}</td>
                                    <td>{{ $each->Name_ContainerType }}</td>
                                    <td class="text-center">{{ $each->Count_Container }}</td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Container, 0, ',', '.') . ' VNĐ' }} </td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="{{ route('orderLocals.makes.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
