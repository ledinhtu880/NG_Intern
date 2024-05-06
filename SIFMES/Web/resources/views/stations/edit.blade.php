@extends('layouts.master')

@section('title', 'Sửa trạm')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('stations.index') }}">Quản lý trạm</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Sửa thông tin trạm</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form id="formInformation" method="POST" action="{{ route('stations.update', compact('station')) }}">
                        @csrf
                        <div class="d-flex gap-3">
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Id_Station" class="form-label">Mã trạm</label>
                                <input type="text" name="Id_Station" id="Id_Station" placeholder="Nhập mã trạm"
                                    class="form-control{{ $errors->has('Id_Station') ? ' is-invalid' : '' }}"
                                    value="{{ $station->Id_Station }}" disabled>
                                <span class="text-danger">
                                    @if ($errors->has('Id_Station'))
                                        {{ $errors->first('Id_Station') }}
                                    @endif
                                </span>
                            </div>
                            @method('PUT')
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Name_Station" class="form-label">Tên trạm</label>
                                <input type="text" name="Name_Station" id="Name_Station" placeholder="Nhập tên trạm"
                                    class="form-control{{ $errors->has('Name_Station') ? ' is-invalid' : '' }}"
                                    value="{{ $station->Name_Station }}" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('Name_Station'))
                                        {{ $errors->first('Name_Station') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Ip_Address" class="form-label">Địa chỉ IP</label>
                            <input type="text" name="Ip_Address" id="Ip_Address" placeholder="Nhập địa chỉ IP"
                                class="form-control{{ $errors->has('Ip_Address') ? ' is-invalid' : '' }}"
                                value="{{ $station->Ip_Address }}" tabindex="2">
                            <span class="text-danger">
                                @if ($errors->has('Ip_Address'))
                                    {{ $errors->first('Ip_Address') }}
                                @endif
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="FK_Id_StationType" class="form-label">Loại trạm</label>
                            <select name="FK_Id_StationType" id="FK_Id_StationType"
                                class="form-select{{ $errors->has('FK_Id_StationType') ? ' is-invalid' : '' }}"
                                tabindex="3">
                                @foreach ($data as $each)
                                    <option value="{{ $each->Id_StationType }}"
                                        @if ($each->Id_StationType == $station->FK_Id_StationType) selected @endif>
                                        {{ $each->Name_StationType }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @if ($errors->has('FK_Id_StationType'))
                                    {{ $errors->first('FK_Id_StationType') }}
                                @endif
                            </span>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{ asset($station->stationType->PathImage) }}"
                                    class="img-thumbnail img-change me-3">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('stations.index') }}" class="btn btn-secondary" tabindex="5">Quay lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $station->Id_Station }}" tabindex="4">
                            Cập nhật
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $station->Id_Station }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật trạm này?
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
@endsection
@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        function validateInput(element, message = null) {
            $(element).on('blur', function() {
                if ($(this).val() == "") {
                    $(this).next().show();
                    $(this).addClass("is-invalid");
                    $(this).next().text(message);
                } else {
                    if ($(this).attr("id") == "Ip_Address") {
                        if (!
                            /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/
                            .test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng nhập đúng định dạng");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else {
                        $(this).next().hide();
                        $(this).removeClass("is-invalid");
                    }
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Id_Station", "Vui lòng nhập mã trạm");
            validateInput("#Name_Station", "Vui lòng nhập tên trạm");
            validateInput("#Ip_Address", "Vui lòng nhập địa chỉ IP");

            $("#FK_Id_StationType").on('change', function() {
                let id = $(this).val();
                $.ajax({
                    url: "/getImgByStationType",
                    type: "POST",
                    data: {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        id: id
                    },
                    success: function(data) {
                        $(".img-change").attr('src', data.PathImage);
                    },
                });
            });
            $("#saveBtn").on('click', function() {
                let isValid = true;
                $(".form-control").each(function(element) {
                    if ($(this).hasClass("is-invalid")) {
                        isValid = false;
                    } else if ($(this).val() == "") {
                        isValid = false;
                        $(this).addClass("is-invalid");
                        $(this).next().text("Trường này là bắt buộc");
                        $(this).next().show();
                    }
                })
                if (isValid) {
                    $("#formInformation").submit();
                }
            })
        });
    </script>
@endpush
