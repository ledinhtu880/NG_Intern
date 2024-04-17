@extends('layouts.master')
@section('title', 'Chi tiết đơn gói hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.orders.index') }}">Theo
                    dõi
                    đơn hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">
                Xem chi tiết
            </li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Thông tin chi tiết gói hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card gap-3">
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
            <div class="card gap-3">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin gói hàng</h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Đơn giá</th>
                                <th scope="col" class="py-2 text-center">Trạng thái dây chuyền</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $each)
                                <tr class="align-middle">
                                    <th class="text-center">{{ $each->Id_ContentPack }}</th>
                                    <td class="text-center">{{ $each->Count_Pack }}</td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="progress h-100 position-relative">
                                                <span class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="{{ $each->progress }}" aria-valuemin="0"
                                                    aria-valuemax="100" style="width: {{ $each->progress }}%;">
                                                    <span
                                                        class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-outline btn-detail"
                                            data-bs-toggle="modal" data-id="{{ $each->Id_ContentPack }}"
                                            data-bs-target="#i{{ $each->Id_ContentPack }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="i{{ $each->Id_ContentPack }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="istaticBackdropLabel">
                                                            Chi tiết gói hàng
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class='table'>
                                                            <thead class="table-heading">
                                                                <tr class="align-middle">
                                                                    <th scope="col" class="py-2">Nguyên liệu</th>
                                                                    <th scope="col" class="py-2">Số lượng nguyên liệu
                                                                    </th>
                                                                    <th scope="col" class="py-2">Đơn vị</th>
                                                                    <th scope="col" class="py-2">Thùng chứa</th>
                                                                    <th scope="col" class="py-2">Số lượng thùng chứa
                                                                    </th>
                                                                    <th scope="col" class="py-2">Đơn giá</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="body-table">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('tracking.orders.index') }}" class="btn btn-secondary">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script>
        $(document).ready(function() {
            $(".btn-detail").on('click', function() {
                let id_ContentPack = $(this).data('id');

                $.ajax({
                    url: '/orders/packs/showPacksDetails',
                    type: 'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                        id_ContentPack: id_ContentPack
                    },
                    success: function(response) {
                        $(".body-table").html(response);
                    }
                });
            });
        });
    </script>
@endpush
