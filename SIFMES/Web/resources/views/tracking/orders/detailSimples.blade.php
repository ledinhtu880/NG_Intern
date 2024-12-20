@extends('layouts.master')

@section('title', 'Thông tin chi tiết thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.orders.index') }}">Theo
                    dõi đơn hàng</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ url()->previous() }}">Xem chi tiết</a>
            <li class=" breadcrumb-item active fw-medium" aria-current="page">
                Thông tin thùng hàng
            </li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Thông tin chi tiết thùng hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card gap-3">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin thùng hàng</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 140px">Mã thùng hàng</label>
                                        <input type=" text" class="form-control" disabled id="Id_ContentSimple"
                                            name="Id_ContentSimple" value="{{ $simple->Id_ContentSimple }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 140px">Tên thùng chứa</label>
                                        <input type=" text" class="form-control" disabled id="Name_ContainerType"
                                            name="Name_ContainerType" value="{{ $simple->type->Name_ContainerType }}">
                                    </div>
                                    <span class="form-message text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 175px">Tên nguyên vật
                                            liệu</label>
                                        <input type="text" class="form-control" disabled id="Name_RawMaterial"
                                            name="Name_RawMaterial" value="{{ $simple->material->Name_RawMaterial }}">
                                    </div>
                                    <span class="form-message text-danger"></span>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 175px">Số lượng thùng
                                            chứa</label>
                                        <input type="text" class="form-control" disabled id="Count_Container"
                                            name="Count_Container" value="{{ $simple->Count_Container }}">
                                    </div>
                                    <span class="form-message text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 200px;">Số lượng nguyên vật
                                            liệu</label>
                                        <input type="text" class="form-control" disabled id="Count_RawMaterial"
                                            name="Count_RawMaterial" value="{{ $simple->Count_RawMaterial }}">
                                    </div>
                                    <span class="form-message text-danger"></span>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <label class="input-group-text bg-light" style="width: 200px;">Đơn giá thùng
                                            chứa</label>
                                        <input type="text" class="form-control" disabled id="Price_Container"
                                            name="Price_Container"
                                            value="{{ number_format($simple->Price_Container, 0, ',', '.') . ' VNĐ' }}">
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="input-group">
                                    <label class="input-group-text bg-light">Tên khách hàng</label>
                                    <input type="text" class="form-control" disabled id="Name_Customer"
                                        name="Name_Customer" value="{{ $simple->order->customer->Name_Customer }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="input-group">
                                    <label class="input-group-text bg-light">Mã đơn hàng</label>
                                    <input type="text" class="form-control" disabled id="Id_Order" name="Id_Order"
                                        value="{{ $simple->order->Id_Order }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <img src="" alt="Hello" class="w-50 h-50 d-none" id="img-js">
                </div>
                <div class="col-md-8">
                    <div class="card gap-3">
                        @if ($simple->progress == 'Thùng hàng chưa được khởi động')
                            <div class="card-header px-3 py-0 border-0 bg-transparent">
                                <h2 class="text-center my-3">Thùng hàng chưa được khởi động</h2>
                            </div>
                        @else
                            <div class="card-body">
                                <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Theo dõi thông tin</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row gap-2">
                                            <div class="input-group">
                                                <label class="input-group-text bg-light" style="width: 215px">
                                                    Trạng thái hiện tại
                                                </label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $simple->status }}">
                                            </div>
                                            <div class="input-group">
                                                <label class="input-group-text bg-light" style="width: 215px">
                                                    Tổng thời gian lưu tại trạm
                                                </label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $simple->elapsedTime }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="wrapped d-flex flex-column align-items-center gap-2">
                                                <label class="nv-label fw-bold">Trạng thái dây chuyền</label>
                                                <div class="d-flex justify-content-center w-100">
                                                    <div class="progress h-100 position-relative">
                                                        <span
                                                            class="progress-bar-value fs-6 fw-bold">{{ $simple->progress }}%</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            aria-valuenow="{{ $simple->progress }}" aria-valuemin="0"
                                                            aria-valuemax="100" style="width: {{ $simple->progress }}%;">
                                                            <span
                                                                class="progress-bar-value fs-6 fw-bold">{{ $simple->progress }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer pt-0 border-0 bg-transparent">
                                <div class="table-responsive">
                                    <table class="table" id="myTable">
                                        <thead class="table-heading">
                                            <t class="align-middle"r>
                                                <th scope="col" class="py-2 text-truncate">Trạm</th>
                                                <th scope="col" class="py-2 text-truncate">Tên trạm</th>
                                                <th scope="col" class="py-2 text-truncate">Trạng thái</th>
                                                <th scope="col" class="py-2 text-truncate">Thời gian lưu tại trạm
                                                </th>
                                            </t>
                                        </thead>
                                        <tbody id="table-data">
                                            @foreach ($data as $each)
                                                <tr data-id="{{ $each->PathImage }}" class="align-middle">
                                                    <td class="text-truncate">{{ $each->Name_Station }}</td>
                                                    <td class="text-truncate">{{ $each->Name_StationType }}</td>
                                                    <td class="text-truncate">{{ $each->status }}</td>
                                                    <td class="text-truncate">{{ $each->elapsedTime }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('message') && session('type'))
        <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        @if (session('type') == 'success')
                            <i class="fas fa-check-circle text-light fs-5"></i>
                        @elseif(session('type') == 'danger' || session('type') == 'warning')
                            <i class="fas fa-xmark-circle text-light fs-5"></i>
                        @elseif(session('type') == 'info' || session('type') == 'secondary')
                            <i class="fas fa-info-circle text-light fs-5"></i>
                        @endif
                        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            let rowElement = $("#table-data tr");
            let imgElement = $("#img-js");

            rowElement.hover(
                function() {
                    let id = $(this).data("id");
                    let src = `{{ asset('${id}') }}`;
                    imgElement.removeClass("d-none");
                    imgElement.attr("src", src);
                },
                function() {
                    imgElement.addClass("d-none");
                    imgElement.attr("src", "");
                }
            );
        });
    </script>
@endpush
