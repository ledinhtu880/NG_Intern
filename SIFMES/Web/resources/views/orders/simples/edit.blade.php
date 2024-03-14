@extends('layouts.master')

@section('title', 'Sửa đơn thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin đơn thùng hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý thùng hàng</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
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
                    <form method="POST" id="formInformation">
                        @csrf
                        <input type="hidden" name="Id_Order" value="{{ $order->Id_Order }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group">
                                            <label class="input-group-text bg-secondary-subtle" for="FK_Id_Customer"
                                                style="width: 130px;">Khách
                                                hàng</label>
                                            <select class="form-select selectValidate" id="FK_Id_Customer"
                                                name="FK_Id_Customer">
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
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <label class="input-group-text bg-secondary-subtle" style="width: 130px;">Ngày
                                                đặt hàng</label>
                                            <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Order)->format('Y-m-d') }}">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group">
                                            <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                                                Ngày giao hàng
                                            </label>
                                            <input type="date" class="form-control" id="Date_Delivery"
                                                name="Date_Delivery"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Delivery)->format('Y-m-d') }}">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group">
                                            <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                                                Ngày nhận hàng
                                            </label>
                                            <input type="date" class="form-control" id="Date_Reception"
                                                name="Date_Reception"
                                                value="{{ \Carbon\Carbon::parse($order->Date_Reception)->format('Y-m-d') }}">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-secondary-subtle">Ghi chú</span>
                                    <textarea class="form-control" style="height: 91px;" aria-label="Notes" name="Note" rows="5">{{ $order->Note }}</textarea>
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
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h5>
                </div>
                <div class="card-body border-0">
                    <div class="wrapper w-100 overflow-x-auto">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="py-3 text-truncate">Nguyên liệu</th>
                                        <th scope="col" class="py-3 text-truncate">Số lượng nguyên liệu</th>
                                        <th scope="col" class="py-3 text-truncate">Đơn vị</th>
                                        <th scope="col" class="py-3 text-truncate">Thùng chứa</th>
                                        <th scope="col" class="py-3 text-truncate">Số lượng thùng chứa</th>
                                        <th scope="col" class="py-3 text-truncate">Đơn giá thùng chứa</th>
                                        <th scope="col" class="py-3 text-truncate">Thành tiền</th>
                                        <th scope="col" class="py-3 text-truncate">Trạng thái</th>
                                        <th scope="col" class="py-3 text-truncate text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    @foreach ($data as $each)
                                        <tr class="js-row" data-id="{{ $each->Id_ContentSimple }}">
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
                                                <button type="button" class="btn btn-sm text-secondary"
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
                                                                <h4 class="modal-title fw-bold text-secondary"
                                                                    id="exampleModalLabel">Xác
                                                                    nhận</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn có chắc chắn muốn xóa thùng hàng này
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-danger btnDelete"
                                                                    data-id="{{ $each->Id_ContentSimple }}">Xóa</button>
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
                <div class="card-footer d-flex align-items-center justify-content-end gap-3">
                    <a href="{{ route('orders.simples.index') }}" class="btn btn-light">Quay lại</a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#deleteOrder-{{ $order->Id_Order }}">
                        Lưu
                    </button>
                    <div class="modal fade" id="deleteOrder-{{ $order->Id_Order }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn cập nhật đơn thùng hàng này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary" id="saveBtn">Xác nhận</button>
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
    <script src="{{ asset('js/orders/simples/edit.js') }}"></script>
    <script>
        $(document).ready(function() {
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
