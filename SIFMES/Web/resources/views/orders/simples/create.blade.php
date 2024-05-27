@extends('layouts.master')

@section('title', 'Tạo đơn thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý đơn thùng hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Tạo đơn thùng hàng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border-0">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form method="POST" id="formInformation">
                        @csrf
                        <input type="hidden" name="Id_Order" id="Id_Order">
                        <input type="hidden" name="count" value="{{ isset($count) ? 1 : 0 }}">
                        <input type="hidden" name="SimpleOrPack" value="0">
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
                                        <span class="text-danger"></span>
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
                                                name="Date_Delivery" {{ isset($information) ? 'readonly' : '' }}
                                                value="{{ isset($information)
                                                    ? \Carbon\Carbon::parse($information->Date_Delivery)->format('Y-m-d')
                                                    : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                tabindex="2">
                                        </div>
                                        <span class="text-danger"></span>
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
                                        <span class="text-danger"></span>
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
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <button type="submit" class="btn btn-primary px-5" id="redirectBtn">
                        <i class="fa-solid fa-warehouse me-2"></i> Lấy thùng hàng từ trong kho
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border-0">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin thùng hàng cần sản xuất mới</h5>
                    <form method="POST" id="formProduct">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_RawMaterial"
                                        style="width: 140px;">
                                        Nguyên vật liệu
                                    </label>
                                    <select name="FK_Id_RawMaterial" id="FK_Id_RawMaterial" class="form-select"
                                        tabindex="6">
                                        @foreach ($materials as $each)
                                            <option value="{{ $each->Id_RawMaterial }}"
                                                data-name="{{ $each->Name_RawMaterial }}">{{ $each->Name_RawMaterial }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group align-items-center">
                                    <label class="input-group-text bg-secondary-subtle" for="Count_RawMaterial">
                                        Số lượng nguyên vật liệu
                                    </label>
                                    <input type="number" name="Count_RawMaterial" id="Count_RawMaterial"
                                        class="form-control"
                                        style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;"
                                        min="1" value='1' tabindex="7">
                                    <p data-name="unit" class="m-0 ps-3"></p>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_ContainerType"
                                        style="width: 140px;">
                                        Thùng chứa
                                    </label>
                                    <select class="form-select selectValidate" name="FK_Id_ContainerType"
                                        id="FK_Id_ContainerType" tabindex="8">
                                        @foreach ($containers as $each)
                                            <option value="{{ $each->Id_ContainerType }}"
                                                data-name="{{ $each->Name_ContainerType }}">
                                                {{ $each->Name_ContainerType }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Count_Container">
                                        Số lượng thùng chứa
                                    </label>
                                    <input type="number" name="Count_Container" id="Count_Container"
                                        style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;"
                                        class="form-control" min="1" value='1' tabindex="9">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Price_Container">
                                        Đơn giá
                                    </label>
                                    <input type="number" name="Price_Container" id="Price_Container"
                                        style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;"
                                        class="form-control" step="0.01" min="1" value='1'
                                        tabindex="10">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary px-5" tabindex="11">
                                <i class="fa-solid fa-plus text-white"></i>
                                Thêm sản phẩm
                            </button>
                        </div>
                    </form>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle text-center">
                                <th class="py-2" scope="col">Nguyên liệu</th>
                                <th class="py-2" scope="col">Số lượng nguyên liệu</th>
                                <th class="py-2" scope="col">Đơn vị</th>
                                <th class="py-2" scope="col">Thùng chứa</th>
                                <th class="py-2" scope="col">Số lượng thùng chứa</th>
                                <th class="py-2" scope="col">Trạng thái</th>
                                <th class="py-2" scope="col">Đơn giá</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @if (isset($data))
                                @foreach ($data as $each)
                                    <tr data-id="{{ $each->Id_ContentSimple }}">
                                        <td class="text-center" data-id="rawMaterialId"
                                            data-value="{{ $each->Id_RawMaterial }}">
                                            {{ $each->Name_RawMaterial }}
                                        </td>
                                        <td class="text-center" data-id="Count_RawMaterial"
                                            data-value="{{ $each->Count_RawMaterial }}">
                                            {{ $each->Count_RawMaterial }}
                                        </td>
                                        <td class="text-center">{{ $each->Unit }}</td>
                                        <td class="text-center" data-id="containerTypeId"
                                            data-value="{{ $each->Id_ContainerType }}">
                                            {{ $each->Name_ContainerType }}
                                        </td>
                                        <td class="text-center" data-id="Count_Container"
                                            data-value="{{ $each->Count_Container }}">
                                            {{ $each->Count_Container }}
                                        </td>
                                        <td class="text-center" data-id="Status"
                                            data-value="{{ $each->Status == 'Lấy từ kho' ? 1 : 0 }}">
                                            {{ $each->Status }}
                                        </td>
                                        <td class="text-center" data-id="Price_Container"
                                            data-value="{{ $each->Price_Container }}">
                                            {{ number_format($each->Price_Container, 0, ',', '.') . ' VNĐ' }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal"
                                                data-bs-target="#deleteID-{{ $each->Id_ContentSimple }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="deleteID-{{ $each->Id_ContentSimple }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-0">Bạn chắc chắn muốn xóa thùng hàng này?</p>
                                                            <p class="m-0">
                                                                Việc này sẽ xóa thùng hàng vĩnh viễn. <br>
                                                                Hãy chắc chắn trước khi tiếp tục.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Hủy</button>
                                                            <button type="button" class="btn btn-danger btnDelete"
                                                                data-id="{{ $each->Id_ContentSimple }}">Xác nhận</button>
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
                        <button class="btn btn-secondary" id="backBtn" tabindex="13">Quay lại</button>
                        <a href="{{ route('orders.simples.index') }}" class="btn btn-primary" id="saveBtn"
                            tabindex="12">Lưu</a>
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
    <script src="{{ asset('js/orders/simples/create.js') }}"></script>
    <script src="{{ asset('js/eventHandler.js') }}"></script>
@endpush
