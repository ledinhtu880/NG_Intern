@extends('layouts.master')

@section('title', 'Thêm thùng hàng vào đơn sản xuất')
@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.makes.edit', $id) }}">Sửa</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm thùng hàng vào đơn sản xuất</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thêm thùng hàng vào đơn sản xuất
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Danh sách thùng hàng</h5>
                    <input type="hidden" name="Id_OrderLocal" value="{{ $id }}">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">Chọn</th>
                                <th scope="col" class="py-2">Khách hàng</th>
                                <th scope="col" class="py-2">Nguyên liệu</th>
                                <th scope="col" class="py-2 text-center">Số lượng nguyên liệu</th>
                                <th scope="col" class="py-2">Thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Số lượng thùng chứa</th>
                                <th scope="col" class="py-2 text-center">Đơn giá thùng chứa</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <td class="text-center" data-id="Id_ContentSimple"
                                    data-value="{{ $each->Id_ContentSimple }}">
                                    <input type="checkbox" class="checkbox form-check-input" name="chk"
                                        id="chk-{{ $each->Id_ContentSimple }}">
                                </td>
                                <td data-id="Name_Customer" data-value="{{ $each->Name_Customer }}" class="text-truncate"
                                    style="max-width: 200px; width: 200px;">
                                    {{ $each->Name_Customer }}
                                </td>
                                <td data-id="Name_RawMaterial" data-value="{{ $each->Name_RawMaterial }}">
                                    {{ $each->Name_RawMaterial }}
                                </td>
                                <td data-id="Count_RawMaterial" data-value="{{ $each->Count_RawMaterial }}"
                                    class="text-center">
                                    {{ $each->Count_RawMaterial }}
                                </td>
                                <td data-id="Name_ContainerType" data-value="{{ $each->Name_ContainerType }}">
                                    {{ $each->Name_ContainerType }}
                                </td>
                                <td data-id="Count_Container" data-value="{{ $each->Count_Container }}"
                                    class="text-center">
                                    {{ $each->Count_Container }}
                                </td>
                                <td data-id="Price_Container" data-value="{{ $each->Price_Container }}"
                                    class="text-center">
                                    {{ number_format($each->Price_Container, 0, '', '') }} VNĐ
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-content-center justify-content-end gap-3">
                        <a href="{{ route('orderLocals.makes.edit', $id) }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary" id="storeSimpleBtn">Lưu</button>
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
