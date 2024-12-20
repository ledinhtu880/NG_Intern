@extends('layouts.master')

@section('title', 'Sửa đơn đóng gói')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.packs.index') }}">Quản lý đơn đóng gói</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Sửa đơn đóng gói</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    @if (isset($inProcess))
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span>Đơn hàng này đang trong quá trình đóng gói, không thể chỉnh sửa</span>
                        </div>
                    @endif
                    @if (session('type'))
                        <input type="hidden" name="checkFlash" value="1">
                    @endif
                    <form action="{{ route('orderLocals.packs.update', $orderLocal) }}" method="POST" id="formInformation">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="Id_OrderLocal" value="{{ $orderLocal->Id_OrderLocal }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Count">
                                        Số lượng
                                    </label>
                                    <input type="number" name="Count" id="Count" class="form-control" min="0"
                                        value="{{ $orderLocal->Count }}" {{ isset($inProcess) ? 'disabled' : '' }}
                                        tabindex="1">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="MakeOrPackOrExpedition">
                                        Trạng thái
                                    </label>
                                    <select disabled class="form-select selectValidate" id="MakeOrPackOrExpedition"
                                        name="MakeOrPackOrExpedition">
                                        @if ($orderLocal->MakeOrPackOrExpedition == 0)
                                            <option value="0" selected>Sản xuất</option>
                                            <option value="1">Gói hàng</option>
                                            <option value="2">Giao hàng</option>
                                        @elseif($orderLocal->MakeOrPackOrExpedition == 1)
                                            <option value="0">Sản xuất</option>
                                            <option value="1" selected>Gói hàng</option>
                                            <option value="2">Giao hàng</option>
                                        @elseif($orderLocal->MakeOrPackOrExpedition == 2)
                                            <option value="0">Sản xuất</option>
                                            <option value="1">Gói hàng</option>
                                            <option value="2" selected>Giao hàng</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                                        Ngày giao hàng
                                    </label>
                                    <input type="date" class="form-control" id="Date_Delivery" name="Date_Delivery"
                                        value="{{ \Carbon\Carbon::parse($orderLocal->Date_Delivery)->format('Y-m-d') }}"
                                        {{ isset($inProcess) ? 'disabled' : '' }} tabindex="2">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Date_Start">
                                        Ngày bắt đầu
                                    </label>
                                    <input type="date" class="form-control" id="Date_Start" name="Date_Start"
                                        value="{{ \Carbon\Carbon::parse($orderLocal->Date_Start)->format('Y-m-d') }}"
                                        {{ isset($inProcess) ? 'disabled' : '' }} tabindex="3">
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
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chi tiết</h5>
                    <table class="table mb-3">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Đơn giá</th>
                                @if (!isset($inProcess))
                                    <th scope="col" class="py-2 text-center"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <tr class="js-row" data-id="{{ $each->Id_ContentPack }}">
                                    <form method="POST">
                                        <th class="text-center">{{ $each->Id_ContentPack }}</th>
                                        <td class="text-center">{{ $each->Count_Pack }}</td>
                                        <td class="text-center">
                                            {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                                        </td>
                                        @if (!isset($inProcess))
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-outline btnShow"
                                                    data-bs-toggle="modal" data-id="{{ $each->Id_ContentPack }}"
                                                    data-bs-target="#i{{ $each->Id_ContentPack }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <div class="modal fade" id="i{{ $each->Id_ContentPack }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="istaticBackdropLabel">Chi tiết
                                                                    gói hàng</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-borderless table-hover m-0">
                                                                    <thead class="table-heading">
                                                                        <tr class="align-middle">
                                                                            <th class="py-2" scope="col">Nguyên liệu
                                                                            </th>
                                                                            <th class="py-2" scope="col">Số lượng
                                                                                nguyên liệu</th>
                                                                            <th class="py-2" scope="col">Đơn vị</th>
                                                                            <th class="py-2" scope="col">Thùng chứa
                                                                            </th>
                                                                            <th class="py-2" scope="col">Số lượng
                                                                                thùng chứa</th>
                                                                            <th class="py-2" scope="col">Đơn giá</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody
                                                                        class="table-packs-{{ $each->Id_ContentPack }}">
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
                                                <button type="button" class="btn btn-sm btn-outline"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteID-{{ $each->Id_ContentPack }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteID-{{ $each->Id_ContentPack }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel">Xác nhận
                                                                </h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-0">Bạn chắc chắn muốn xóa gói hàng này?
                                                                </p>
                                                                <p class="m-0">
                                                                    Việc này sẽ xóa gói hàng vĩnh viễn. <br>
                                                                    Hãy chắc chắn trước khi tiếp tục.
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-danger btnDelete"
                                                                    data-id="{{ $each->Id_ContentPack }}">Xác
                                                                    nhận</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-secondary" tabindex="5">Quay
                            lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $orderLocal->Id_OrderLocal }}"
                            {{ isset($inProcess) ? 'disabled' : '' }} tabindex="4">
                            Lưu
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $orderLocal->Id_OrderLocal }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật đơn gói hàng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="updateBtn">Xác nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script>
        $(document).ready(function() {
            function validateInput(element, message = null) {
                $(element).on('blur', function() {
                    if ($(this).attr("id") == "Count") {
                        if ($(this).val() == "") {
                            $(this).addClass("is-invalid");
                            $(this).parent().next().text(message);
                            $(this).parent().next().show();
                        } else if (parseInt($(this).val(), 10) <= 0) {
                            $(this).parent().next().show();
                            $(this).parent().next().text("Số lượng phải lớn hơn 0");
                            $(this).addClass("is-invalid");
                        } else {
                            $(this).parent().next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    }
                });
            }

            validateInput("#Count", "Vui lòng nhập số lượng")

            let token = $('meta[name="csrf-token"]').attr("content");
            let ware = $("input[name='warehouse']").val();
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

            $(document).on("click", ".btnDelete", function() {
                let id = $(this).data("id");
                let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
                let token = $('meta[name="csrf-token"]').attr("content");
                let rowElement = $(this).closest('tr[data-id="' + id + '"]');

                // Xóa hàng khi modal được ẩn
                $.ajax({
                    url: "/orderLocals/packs/destroyPack",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        modalElement.on("hidden.bs.modal", function() {
                            showToast(
                                "Xóa gói hàng thành công",
                                "bg-warning",
                                "fa-check-circle"
                            );
                            rowElement.remove();
                        });
                        // Đóng modal
                        modalElement.modal("hide");
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

            $("#updateBtn").on("click", function() {
                if ($("#Count").val() <= 0) {
                    showToast(
                        "Số lượng phải lớn hơn 0",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    $("#formInformation").submit();
                }
            });
        });
    </script>
@endpush
