@extends('layouts.master')

@section('title', 'Sửa đơn sản xuất')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Sửa đơn sản xuất</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
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
                    @if (isset($inProcess))
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span>Đơn hàng này đang trong quá trình sản xuất, không thể chỉnh sửa</span>
                        </div>
                    @endif
                    <form action="{{ route('orderLocals.makes.update', $orderLocal) }}" method="POST" id="formInformation">
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
                                        value="{{ $orderLocal->Count }}" {{ isset($inProcess) ? 'disabled' : '' }}>
                                </div>
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
                                        {{ isset($inProcess) ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <label class="input-group-text bg-secondary-subtle" for="Date_Start">
                                        Ngày bắt đầu
                                    </label>
                                    <input type="date" class="form-control" id="Date_Start" name="Date_Start"
                                        value="{{ \Carbon\Carbon::parse($orderLocal->Date_Start)->format('Y-m-d') }}"
                                        {{ isset($inProcess) ? 'disabled' : '' }}>
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
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chi tiết</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Nguyên liệu</th>
                                <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
                                <th scope="col" class="py-3">Đơn vị</th>
                                <th scope="col" class="py-3">Thùng chứa</th>
                                <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
                                <th scope="col" class="py-3 text-center">Đơn giá thùng chứa</th>
                                <th scope="col" class="py-3 text-center">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <tr data-id="{{ $each->Id_ContentSimple }}">
                                    <th scope="row" class="text-center text-body-secondary">
                                        {{ $each->Id_ContentSimple }}</th>
                                    <td>{{ $each->Name_RawMaterial }}</td>
                                    <td class="text-center">{{ $each->Count_RawMaterial }}</td>
                                    <td>{{ $each->Unit }}</td>
                                    <td>{{ $each->Name_ContainerType }}</td=>
                                    <td class="text-center">{{ $each->Count_Container }}</td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Container, 0, '', '') }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                                    </td>
                                    @if (!isset($inProcess))
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm text-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteID-{{ $each->Id_ContentSimple }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="deleteID-{{ $each->Id_ContentSimple }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fw-bold text-secondary"
                                                                id="exampleModalLabel">Xác nhận</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between gap-2">
                    <a href="{{ route('orderLocals.makes.addSimple', $orderLocal) }}"
                        class="btn btn-primary{{ isset($inProcess) ? ' btn-disabled' : '' }}">
                        <span>Thêm đơn thùng hàng</span>
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orderLocals.makes.index') }}" class="btn btn-light">Quay lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $orderLocal->Id_OrderLocal }}"
                            {{ isset($inProcess) ? 'disabled' : '' }}>
                            Lưu
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $orderLocal->Id_OrderLocal }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật đơn sản xuất này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
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
    <script src="{{ asset('js/orderLocals/makes/edit.js') }}"></script>
@endpush