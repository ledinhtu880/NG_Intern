@extends('layouts.master')

@section('title', 'Thêm khách hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('customers.index') }}">Quản lý khách hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thêm khách hàng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form id="formInformation" method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <div class="d-flex gap-2">
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Name_Customer" class="form-label">Tên khách
                                    hàng</label>
                                <input type="text" name="Name_Customer" id="Name_Customer"
                                    class="form-control{{ $errors->has('Name_Customer') ? ' is-invalid' : '' }}"
                                    value="{{ old('Name_Customer') }}" placeholder="Nhập tên khách hàng" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('Name_Customer'))
                                        {{ $errors->first('Name_Customer') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Name_Contact" class="form-label">Tên liên hệ</label>
                                <input type="text" name="Name_Contact" id="Name_Contact"
                                    class="form-control{{ $errors->has('Name_Contact') ? ' is-invalid' : '' }}"
                                    value="{{ old('Name_Contact') }}" placeholder="Nhập tên liên hệ" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('Name_Contact'))
                                        {{ $errors->first('Name_Contact') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Email" class="form-label">Email</label>
                                <input type="text" name="Email" id="Email" placeholder="Nhập email"
                                    class="form-control{{ $errors->has('Email') ? ' is-invalid' : '' }}"
                                    value="{{ old('Email') }}" tabindex="3">
                                <span class="text-danger">
                                    @if ($errors->has('Email'))
                                        {{ $errors->first('Email') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Phone" class="form-label">Phone</label>
                                <input type="text" name="Phone" id="Phone" placeholder="Nhập số điện thoại"
                                    class="form-control{{ $errors->has('Phone') ? ' is-invalid' : '' }}"
                                    value="{{ old('Phone') }}" tabindex="4">
                                <span class="text-danger">
                                    @if ($errors->has('Phone'))
                                        {{ $errors->first('Phone') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Address" class="form-label">Địa chỉ</label>
                                <input type="text" name="Address" id="Address" placeholder="Nhập địa chỉ"
                                    class="form-control{{ $errors->has('Address') ? ' is-invalid' : '' }}"
                                    value="{{ old('Address') }}" tabindex="5">
                                <span class="text-danger">
                                    @if ($errors->has('Address'))
                                        {{ $errors->first('Address') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Zipcode" class="form-label">Zipcode</label>
                                <input type="number" name="Zipcode" id="zipcode" placeholder="Nhập zipcode"
                                    class="form-control{{ $errors->has('Zipcode') ? ' is-invalid' : '' }}"
                                    value="{{ old('Zipcode') }}" tabindex="6">
                                <span class="text-danger">
                                    @if ($errors->has('Zipcode'))
                                        {{ $errors->first('Zipcode') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group" style="flex: 1">
                                <label for="FK_Id_Mode_Transport" class="form-label">Phương
                                    thức vận
                                    chuyển</label>
                                <select name="FK_Id_Mode_Transport"
                                    class="form-select{{ $errors->has('FK_Id_Mode_Transport') ? ' is-invalid' : '' }}"
                                    tabindex="7">
                                    @foreach ($data as $each)
                                        <option value="{{ $each->Id_ModeTransport }}">{{ $each->Name_ModeTransport }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @if ($errors->has('FK_Id_Mode_Transport'))
                                        {{ $errors->first('FK_Id_Mode_Transport') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group" style="flex: 1">
                                <label for="FK_Id_CustomerType" class="form-label">Chọn kiểu
                                    khách hàng</label>
                                <select name="FK_Id_CustomerType"
                                    class="form-select{{ $errors->has('FK_Id_CustomerType') ? ' is-invalid' : '' }}"
                                    tabindex="8">
                                    @foreach ($customerTypes as $each)
                                        <option value="{{ $each->Id }}">{{ $each->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @if ($errors->has('FK_Id_CustomerType'))
                                        {{ $errors->first('FK_Id_CustomerType') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary" tabindex="10">Quay lại</a>
                        <button type="submit" class="btn btn-primary" id="saveBtn" tabindex="9">Lưu</button>
                    </div>
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
                    if ($(this).attr("id") == "Email") {
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng nhập đúng định dạng email");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "Phone") {
                        if (!/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng nhập đúng định dạng số điện thoại");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "zipcode") {
                        if (!/^[0-9]{5}(?:-[0-9]{4})?$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng nhập đúng định dạng");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "Name_Customer") {
                        if (!/^[a-zA-ZÀ-ỹ\s]+$/.test($(this).val())) {
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
            validateInput("#Name_Customer", "Vui lòng nhập tên khách hàng");
            validateInput("#Name_Contact", "Vui lòng nhập tên liên hệ");
            validateInput("#Email", "Vui lòng nhập email");
            validateInput("#Phone", "Vui lòng nhập số điện thoại");
            validateInput("#Address", "Vui lòng nhập địa chỉ");
            validateInput("#zipcode", "Vui lòng nhập zipcode");

            $("#saveBtn").on('click', function() {
                let isValid = true;

                $(".form-control").each(function(element) {
                    if ($(this).hasClass("is-invalid")) {
                        isValid = false;
                    } else if ($(this).val() == "") {
                        isValid = false;
                        $(this).next().show();
                        $(this).addClass("is-invalid");
                        $(this).next().text("Trường này là bắt buộc");
                    }
                })
                if (isValid) {
                    $("#formInformation").submit();
                }
            })
        })
    </script>
@endpush
