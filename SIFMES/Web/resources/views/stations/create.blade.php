@extends('layouts.master')

@section('title', 'Thêm trạm')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('stations.index') }}">Quản lý trạm</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thêm trạm
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form id="formInformation" method="POST" action="{{ route('stations.store') }}">
                        @csrf
                        <div class="d-flex gap-2 mb-3">
                            <div class="form-group flex-fill">
                                <label for="Id_Station" class="form-label">Mã trạm</label>
                                <input type="text" name="Id_Station" id="Id_Station" placeholder="Nhập mã trạm"
                                    class="form-control{{ $errors->has('Id_Station') ? ' is-invalid' : '' }}"
                                    value="{{ old('Id_Station') }}" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('Id_Station'))
                                        {{ $errors->first('Id_Station') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group flex-fill">
                                <label for="Name_Station" class="form-label">Tên trạm</label>
                                <input type="text" name="Name_Station" id="Name_Station" placeholder="Nhập tên trạm"
                                    class="form-control{{ $errors->has('Name_Station') ? ' is-invalid' : '' }}"
                                    value="{{ old('Name_Station') }}" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('Name_Station'))
                                        {{ $errors->first('Name_Station') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Ip_Address" class="form-label">Địa chỉ IP</label>
                            <input type="text" name="Ip_Address" id="Ip_Address" placeholder="Nhập địa chỉ IP"
                                class="form-control{{ $errors->has('Ip_Address') ? ' is-invalid' : '' }}"
                                value="{{ old('Ip_Address') }}" tabindex="3">
                            <span class="text-danger">
                                @if ($errors->has('Ip_Address'))
                                    {{ $errors->first('Ip_Address') }}
                                @endif
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="FK_Id_StationType" class="form-label">Loại trạm</label>
                            <select name="FK_Id_StationType"
                                class="form-select{{ $errors->has('FK_Id_StationType') ? ' is-invalid' : '' }}"
                                tabindex="4">
                                <option value="">Chọn loại trạm</option>
                                @foreach ($data as $each)
                                    <option value="{{ $each->Id_StationType }}">{{ $each->Name_StationType }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @if ($errors->has('FK_Id_StationType'))
                                    {{ $errors->first('FK_Id_StationType') }}
                                @endif
                            </span>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('stations.index') }}" class="btn btn-secondary" tabindex="6">Quay lại</a>
                        <button type="submit" class="btn btn-primary" id="saveBtn" tabindex="5">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('javascript')
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
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
            })
        </script>
    @endpush
