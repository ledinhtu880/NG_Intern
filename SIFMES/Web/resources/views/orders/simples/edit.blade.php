@extends('layouts.master')

@section('title', 'Sửa đơn thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý thùng hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Sửa đơn thùng hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form method="POST" id="formInformation">
                        @csrf
                        <input type="hidden" name="Id_Order" value="{{ $order->Id_Order }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="FK_Id_Customer" class="form-label">Khách hàng</label>
                                            <select class="form-select selectValidate" id="FK_Id_Customer"
                                                name="FK_Id_Customer" tabindex="1">
                                                @foreach ($customers as $each)
                                                    @if ($each->Id_Customer == $order->FK_Id_Customer)
                                                        <option value="{{ $each->Id_Customer }}" selected>
                                                            {{ $each->Name_Customer }}</option>
                                                    @else
                                                        <option value="{{ $each->Id_Customer }}">{{ $each->Name_Customer }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="Date_Order" class="form-label">Ngày đặt hàng</label>
                                            <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Order)->format('Y-m-d') }}"
                                                tabindex="3">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="Date_Delivery" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="Date_Delivery"
                                                name="Date_Delivery"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Delivery)->format('Y-m-d') }}"
                                                tabindex="2">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="Date_Reception" class="form-label">Ngày nhận hàng</label>
                                            <input type="date" class="form-control" id="Date_Reception"
                                                name="Date_Reception"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Reception)->format('Y-m-d') }}"
                                                tabindex="4">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Note" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" aria-label="Notes" name="Note" id="Note" rows="5" tabindex="5">{{ $order->Note }}</textarea>
                                </div>
                                <span class="text-danger"></span>
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
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin thùng hàng</h5>
                    <div class="wrapper w-100 overflow-x-auto">
                        <div class="table-responsive">
                            <table class="table table-borderless m-0">
                                <thead class="table-heading">
                                    <tr class="align-middle">
                                        <th scope="col" class="py-2 text-truncate">Nguyên liệu</th>
                                        <th scope="col" class="py-2 text-truncate">Số lượng nguyên liệu</th>
                                        <th scope="col" class="py-2 text-truncate">Đơn vị</th>
                                        <th scope="col" class="py-2 text-truncate">Thùng chứa</th>
                                        <th scope="col" class="py-2 text-truncate">Số lượng thùng chứa</th>
                                        <th scope="col" class="py-2 text-truncate">Đơn giá thùng chứa</th>
                                        <th scope="col" class="py-2 text-truncate">Thành tiền</th>
                                        <th scope="col" class="py-2 text-truncate">Trạng thái</th>
                                        <th scope="col" class="py-2 text-truncate text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    @foreach ($data as $each)
                                        <tr class="js-row align-middle" data-id="{{ $each->Id_ContentSimple }}">
                                            <td>
                                                <select class="form-select selectValidate" style="width: 150px"
                                                    id="FK_Id_RawMaterial" name="FK_Id_RawMaterial">
                                                    @foreach ($materials as $material)
                                                        @if ($each->FK_Id_RawMaterial == $material->Id_RawMaterial)
                                                            <option value="{{ $material->Id_RawMaterial }}" selected>
                                                                {{ $material->Name_RawMaterial }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $material->Id_RawMaterial }}">
                                                                {{ $material->Name_RawMaterial }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" name="Count_RawMaterial"
                                                    id="Count_RawMaterial" value="{{ $each->Count_RawMaterial }}"
                                                    min="0">
                                            </td>
                                            <td data-name="unit" class="text-nowrap align-middle">{{ $each->Unit }}
                                            </td>
                                            <td>
                                                <select class="form-select selectValidate" style="width: 150px"
                                                    id="FK_Id_ContainerType" name="FK_Id_ContainerType">
                                                    @foreach ($containers as $container)
                                                        @if ($container->Id_ContainerType == $each->FK_Id_ContainerType)
                                                            <option value="{{ $container->Id_ContainerType }}" selected>
                                                                {{ $container->Name_ContainerType }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $container->Id_ContainerType }}">
                                                                {{ $container->Name_ContainerType }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" name="Count_Container"
                                                    id="Count_Container" value="{{ $each->Count_Container }}"
                                                    min="0">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" name="Price_Container"
                                                    id="Price_Container" value="{{ $each->Price_Container }}"
                                                    min="0" step="0.01">
                                            </td>
                                            <td class="text-truncate align-middle" data-id="total">
                                                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                                            </td>
                                            <td class="text-truncate align-middle" data-id="Status"
                                                data-value="{{ $each->Status == 'Sản xuất mới' ? 0 : 1 }}">
                                                {{ $each->Status }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-outline"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteID-{{ $each->Id_ContentSimple }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteID-{{ $each->Id_ContentSimple }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel">Xác
                                                                    nhận</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-0">Bạn chắc chắn muốn xóa thùng hàng này?
                                                                </p>
                                                                <p class="m-0">
                                                                    Việc này sẽ xóa thùng hàng vĩnh viễn. <br>
                                                                    Hãy chắc chắn trước khi tiếp tục.
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-danger btnDelete"
                                                                    data-id="{{ $each->Id_ContentSimple }}">Xác
                                                                    nhận</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <a href="{{ route('orders.simples.index') }}" class="btn btn-secondary" tabindex="7">Quay
                            lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $order->Id_Order }}" tabindex="6">
                            Lưu
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $order->Id_Order }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật đơn thùng hàng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Xác nhận</button>
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
    <script src="{{ asset('js/orders/simples/edit.js') }}"></script>
    <script>
        function validateInput(element, message) {
            $(element).on('blur', function() {
                if ($(this).attr("id") == "Note") {
                    if ($(this).val() == "") {
                        $(this).addClass("is-invalid");
                        $(this).closest(".form-group").next().text(message);
                        $(this).closest(".form-group").next().show();
                    } else {
                        $(this).closest(".form-group").next().hide();
                        $(this).removeClass("is-invalid");
                    }
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Note", "Mô tả không được để trống")
            let token = $('meta[name="csrf-token"]').attr("content");
            $(".js-row").each(function(index, element) {
                let isTake = $(element).find("td[data-id='Status']").data("value");
                if (isTake == 1) {
                    $(element).find("select").prop("disabled", true);
                    $(element).find("input").prop("disabled", true);
                    let id = $(this).data("id");
                    $.ajax({
                        url: "/wares/disabledContentSimple",
                        method: "POST",
                        dataType: "json",
                        data: {
                            id: id,
                            _token: token,
                        },
                        success: function(response) {
                            if (!response) {
                                $(element).find("input[name='Count_Container']").prop(
                                    "disabled",
                                    true)
                            } else {
                                $(element).find("input[name='Count_Container']").prop(
                                    "disabled", false)
                            }
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert(
                                "Có lỗi xảy ra. Vui lòng thử lại sau."
                            );
                        },
                    });
                }
            });
        });
    </script>
@endpush
