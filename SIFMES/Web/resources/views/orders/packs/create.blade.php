@extends('layouts.master')

@section('title', 'Tạo gói hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Tạo đơn gói hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form method="POST" id="formInformation">
                        @csrf
                        <input type="hidden" name="count" value="{{ isset($count) ? 1 : 0 }}">
                        <input type="hidden" name="SimpleOrPack" value="1">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="FK_Id_Customer" class="form-label">Khách hàng</label>
                                            <select class="form-select selectValidate" id="FK_Id_Customer"
                                                name="FK_Id_Customer" tabindex="1">
                                                @foreach ($customers as $each)
                                                    @if (isset($information))
                                                        @if ($information->FK_Id_Customer == $each->Id_Customer)
                                                            <option value="{{ $each->Id_Customer }}" selected>
                                                                {{ $each->Name_Customer }}</option>
                                                        @else
                                                            <option value="{{ $each->Id_Customer }}" disabled>
                                                                {{ $each->Name_Customer }}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $each->Id_Customer }}">{{ $each->Name_Customer }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="Date_Order" class="form-label">Ngày đặt hàng</label>
                                            <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                                                {{ isset($information) ? 'readonly' : '' }}
                                                value="{{ isset($information)
                                                    ? \Carbon\Carbon::parse($information->Date_Order)->format('Y-m-d')
                                                    : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                tabindex="3">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="Date_Delivery" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="Date_Delivery"
                                                name="Date_Delivery" {{ isset($information) ? 'readonly' : '' }}
                                                value="{{ isset($information)
                                                    ? \Carbon\Carbon::parse($information->Date_Delivery)->format('Y-m-d')
                                                    : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                tabindex="2">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="Date_Reception" class="form-label">Ngày nhận hàng</label>
                                            <input type="date" class="form-control" id="Date_Reception"
                                                name="Date_Reception" {{ isset($information) ? 'readonly' : '' }}
                                                value="{{ isset($information)
                                                    ? \Carbon\Carbon::parse($information->Date_Reception)->format('Y-m-d')
                                                    : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                tabindex="4">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Note" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" aria-label="Notes" name="Note" id="Note"
                                        {{ isset($information) ? 'readonly' : '' }} rows="5" tabindex="5">{{ isset($information) ? $information->Note : '' }}</textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin gói hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <button type="submit" class="btn btn-primary px-5" id="addBtn" tabindex="6">
                            <i class="fa-solid fa-plus text-white me-2"></i>Thêm gói hàng
                        </button>
                        <button type="submit" class="btn btn-primary px-5" id="redirectBtn">
                            <i class="fa-solid fa-warehouse me-2"></i> Lấy gói hàng từ trong kho
                        </button>
                    </div>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Đơn giá</th>
                                <th scope="col" class="py-2 text-center">Trạng thái</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @if (isset($data))
                                @foreach ($data as $each)
                                    <tr data-id="{{ $each->Id_ContentPack }}">
                                        <td class="text-center">{{ $each->Id_ContentPack }}</td>
                                        <td class="text-center">{{ $each->Count_Pack }} gói hàng</td>
                                        <td class="text-center">
                                            {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                                        </td>
                                        <td class="text-center">{{ $each->Status }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal"
                                                data-bs-target="#deleteID-{{ $each->Id_ContentPack }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="deleteID-{{ $each->Id_ContentPack }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-0">Bạn chắc chắn muốn xóa gói hàng này?</p>

                                                            <p class="m-0">
                                                                Việc này sẽ xóa gói hàng vĩnh viễn. <br>
                                                                Hãy chắc chắn trước khi tiếp tục.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Hủy</button>
                                                            <button type="button" class="btn btn-primary btnDelete"
                                                                data-id="{{ $each->Id_ContentPack }}">Xác nhận</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-secondary" id="backBtn" tabindex="8">Quay lại</button>
                        <a href="{{ route('orders.packs.index') }}" class="btn btn-primary" tabindex="7">Lưu</a>
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
    <script src="{{ asset('js/orders/packs/create.js') }}"></script>
    <script>
        function validateInput(element, message) {
            $(element).on("blur", function() {
                if ($(this).val() == "") {
                    $(this).addClass("is-invalid");
                    $(this).next().show();
                    if ($(this).attr("id") == "Note") {
                        $(this).next().text(message);
                        $(this).next().show();
                    } else {
                        $(this).closest(".input-group").next().text(message);
                        $(this).closest(".input-group").next().show();
                    }
                } else {
                    if ($(this).attr("id") == "Note") {
                        $(this).next().hide();
                    } else {
                        $(this).closest(".input-group").next().hide();
                    }
                    $(this).removeClass("is-invalid");
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Note", "Mô tả không được để trống");
            let token = $('meta[name="csrf-token"]').attr("content");
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

            toastLiveExample.on('hidden.bs.toast', function() {
                var bgColorClass = $(".toast-body").data("bg-color-class");
                var iconClass = $("#icon").data("icon-class");

                $(".toast-body").removeClass(bgColorClass);
                $("#icon").removeClass(iconClass);

                $("#toast-msg").html('');
            });

            function showToast(message, bgColorClass, iconClass) {
                $(".toast-body").data("bg-color-class", bgColorClass);
                $("#icon").data("icon-class", iconClass);

                $(".toast-body").addClass(bgColorClass);
                $("#icon").addClass(iconClass);
                $("#toast-msg").html(message);
                toastBootstrap.show();
            }

            $(document).on("click", ".btnDelete", function() {
                let id = $(this).data("id");
                let modalElement = $("#deleteID-" + id);
                let rowElement = $(this).closest('tr[data-id="' + id + '"]');
                $.ajax({
                    url: "/orders/packs/deletePacks",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        modalElement.on("hidden.bs.modal", function() {
                            rowElement.remove();
                        });

                        // Đóng modal
                        modalElement.modal("hide");
                        showToast(
                            "Xóa gói hàng thành công",
                            "bg-success",
                            "fa-check-circle"
                        );
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

            $("#backBtn").on('click', function() {
                let urlParams = new URLSearchParams(window.location.search);
                let id = urlParams.get("id");
                $.ajax({
                    url: "/orders/packs/destroyPacksWhenBack",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        window.location.href = "{{ route('orders.packs.index') }}"
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            })
        })
    </script>
@endpush
