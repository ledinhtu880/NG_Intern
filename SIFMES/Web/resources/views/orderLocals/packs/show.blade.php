@extends('layouts.master')

@section('title', 'Chi tiết đơn đóng gói')

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
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thông tin đơn đóng gói
        </h4>
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
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chi tiết</h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Đơn giá</th>
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
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-outline btnShow" data-bs-toggle="modal"
                                            data-id="{{ $each->Id_ContentPack }}"
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
                                                        <h4 class="modal-title" id="istaticBackdropLabel">Chi tiết gói hàng
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-borderless table-hover m-0">
                                                            <thead class="table-heading">
                                                                <tr class="align-middle">
                                                                    <th class="py-2" scope="col">Nguyên liệu</th>
                                                                    <th class="py-2" scope="col">Số lượng nguyên liệu
                                                                    </th>
                                                                    <th class="py-2" scope="col">Đơn vị</th>
                                                                    <th class="py-2" scope="col">Thùng chứa</th>
                                                                    <th class="py-2" scope="col">Số lượng thùng chứa
                                                                    </th>
                                                                    <th class="py-2" scope="col">Đơn giá</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-packs-{{ $each->Id_ContentPack }}">
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
                    <div class="d-flex justify-content-end align-items-center"><a
                            href="{{ route('orderLocals.packs.index') }}" class="btn btn-secondary">Quay lại</a>
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
                            htmls += `<tr class="align-middle">
                                        <td class="text-center">${value.Name_RawMaterial}</td>
                                        <td class="text-center">${value.Count_RawMaterial}</td>
                                        <td class="text-center">${value.Unit}</td>
                                        <td class="text-center">${value.Name_ContainerType}</td>
                                        <td class="text-center">${value.Count_Container}</td>
                                        <td class="text-center">${numberFormat(value.Price_Container)} VNĐ </td>
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
