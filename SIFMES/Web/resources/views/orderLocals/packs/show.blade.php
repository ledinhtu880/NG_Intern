@extends('layouts.master')

@section('title', 'Chi tiết đơn đóng gói')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin đơn gói hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orderLocals.packs.index') }}">Quản lý đơn gói hàng</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
                </div>
                <div class="card-body">
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
                                {{ $orderLocal->Count }} gói
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
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chi tiết</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3 text-center">Số lượng</th>
                                <th scope="col" class="py-3 text-center">Đơn giá</th>
                                <th scope="col" class="py-3 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $each)
                                <tr>
                                    <th class="text-center">{{ $each->Id_ContentPack }}</th>
                                    <td class="text-center">{{ $each->Count_Pack }}</td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                    <td class="text-center">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm text-secondary btnShow"
                                            data-bs-toggle="modal" data-id="{{ $each->Id_ContentPack }}"
                                            data-bs-target="#i{{ $each->Id_ContentPack }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="i{{ $each->Id_ContentPack }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title fw-bold text-secondary"
                                                            id="istaticBackdropLabel">Chi tiết gói hàng
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="py-3" scope="col">Nguyên liệu</th>
                                                                    <th class="py-3" scope="col">Số lượng nguyên liệu
                                                                    </th>
                                                                    <th class="py-3" scope="col">Đơn vị</th>
                                                                    <th class="py-3" scope="col">Thùng chứa</th>
                                                                    <th class="py-3" scope="col">Số lượng thùng chứa
                                                                    </th>
                                                                    <th class="py-3" scope="col">Đơn giá</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-packs-{{ $each->Id_ContentPack }}">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
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
                <div class="card-footer d-flex align-items-center justify-content-end">
                    <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-light">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            let token = $('meta[name="csrf-token"]').attr("content");
            let ware = $("input[name='warehouse']").val();
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

            $(document).on("click", ".btnShow", function() {
                let id = $(this).data("id");
                $.ajax({
                    url: "/orderLocals/packs/showSimpleInPack",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        let data = response;
                        let table = $(".table-packs-" + id);
                        let htmls = "";
                        $.each(data, function(key, value) {
                            htmls += `<tr>
                        <td class="text-center">${value.Name_RawMaterial}</td>
                        <td class="text-center">${value.Count_RawMaterial}</td>
                        <td class="text-center">${value.Unit}</td>
                        <td class="text-center">${value.Name_ContainerType}</td>
                        <td class="text-center">${value.Count_Container}</td>
                        <td class="text-center">${numberFormat(
              value.Price_Container
            )} VNĐ </td>
                        </tr>`;
                        });
                        table.html(htmls);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });
        });
    </script>
@endpush
