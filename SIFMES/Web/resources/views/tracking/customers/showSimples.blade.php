@extends('layouts.master')

@section('title', 'Chi tiết đơn thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.customers.index') }}">Theo
                    dõi khách hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thông tin thùng hàng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thông tin thùng hàng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Mã đơn hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->Id_Order }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Tên khách hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->customer->Name_Customer }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày đặt hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->order_date }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày giao hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->delivery_date }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ngày nhận hàng
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->reception_date }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="card-subtitle" style="font-weight: 600;">
                                Ghi chú
                            </h6>
                            <p class="card-text text-secondary fw-normal">
                                {{ $order->Note }}
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
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin thùng hàng</h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Nguyên liệu</th>
                                <th scope="col" class="py-2">Đơn vị</th>
                                <th scope="col" class="py-2">Thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Thành tiền</th>
                                <th scope="col" class="py-2 text-center">Trạng thái dây chuyền</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <tr class="align-middle">
                                    <td class="text-center">{{ $each->Id_ContentSimple }}</td>
                                    <td>{{ $each->Name_RawMaterial }}</td>
                                    <td>{{ $each->Unit }}</td>
                                    <td>{{ $each->Name_ContainerType }}</td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($each->progress == 'Chưa có thông tin')
                                            <p class="m-0">{{ $each->progress }}</p>
                                        @else
                                            <div class="d-flex justify-content-center">
                                                <div class="progress h-100 position-relative">
                                                    <span
                                                        class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                    <div class="progress-bar" role="progressbar"
                                                        aria-valuenow="{{ $each->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: {{ $each->progress }}%;">
                                                        <span
                                                            class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tracking.orders.showDetailsSimple', $each->Id_ContentSimple) }}"
                                            class="btn btn-sm btn-outline btn-detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('tracking.customers.index') }}" class="btn btn-secondary" id="btnBack">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            let maxTabIndex = Math.max.apply(
                null,
                $("*")
                .map(function() {
                    let tabIndex = $(this).attr("tabindex");
                    return tabIndex ?
                        parseInt(tabIndex, 10) :
                        -Infinity; // Chuyển đổi thành số nguyên
                })
                .get()
            );
            let count = 1;

            $("#table-data .btn.btn-detail").each(function() {
                $(this).attr("tabindex", count + maxTabIndex);
                count++;
            })

            $("#btnBack").attr("tabindex", count + maxTabIndex);
        })
    </script>
@endpush
