@extends('layouts.master')

@section('title', 'Sửa nguyên liệu thô')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Sửa nguyên liệu thô
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <form id="formInformation" method="POST"
                        action="{{ route('rawMaterials.update', $material->Id_RawMaterial) }}">
                        @csrf
                        @method('PUT')
                        <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                        <div class="d-flex gap-2">
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Name_RawMaterial" class="form-label">Tên nguyên
                                    liệu</label>
                                <input type="text" name="Name_RawMaterial" id="Name_RawMaterial"
                                    placeholder="Nhập tên nguyên liệu thô" value="{{ $material->Name_RawMaterial }}"
                                    class="form-control{{ $errors->has('Name_RawMaterial') ? ' is-invalid' : '' }}"
                                    tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('Name_RawMaterial'))
                                        {{ $errors->first('Name_RawMaterial') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group mb-3" style="flex: 1">
                                <label for="Unit" class="form-label">Đơn vị</label>
                                <input type="text" name="Unit" id="Unit" placeholder="Nhập đơn vị"
                                    value="{{ $material->Unit }}"
                                    class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('Unit'))
                                        {{ $errors->first('Unit') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group" style="flex: 1">
                                <label for="Count" class="form-label">Số lượng</label>
                                <input type="number" name="Count" id="Count" placeholder="Nhập số lượng"
                                    value="{{ $material->Count }}"
                                    class="form-control{{ $errors->has('Count') ? ' is-invalid' : '' }}" tabindex="3">
                                <span class="text-danger">
                                    @if ($errors->has('Count'))
                                        {{ $errors->first('Count') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group" style="flex: 1">
                                <label for="FK_Id_RawMaterialType" class="form-label">Loại nguyên
                                    liệu</label>
                                <select name="FK_Id_RawMaterialType"
                                    class="form-select{{ $errors->has('FK_Id_RawMaterialType') ? ' is-invalid' : '' }}"
                                    tabindex="4">
                                    @foreach ($data as $each)
                                        @if ($each->id == $material->FK_Id_RawMaterialType)
                                            <option value="{{ $each->id }}" selected>{{ $each->Name_RawMaterialType }}
                                            </option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->Name_RawMaterialType }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @if ($errors->has('FK_Id_RawMaterialType'))
                                        {{ $errors->first('FK_Id_RawMaterialType') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('rawMaterials.index') }}" class="btn btn-secondary" tabindex="6">Quay lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $material->Id_RawMaterial }}" tabindex="5">
                            Cập nhật
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $material->Id_RawMaterial }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fw-bold" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật nguyên liệu thô này?
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
    <script>
        function validateInput(element, message = null) {
            $(element).on('blur', function() {
                if ($(this).val() == "") {
                    $(this).next().show();
                    $(this).addClass("is-invalid");
                    $(this).next().text(message);
                } else {
                    if ($(this).attr("id") == "Name_RawMaterial") {
                        if (!/^[a-zA-ZÀ-ỹ\s]+$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng nhập đúng định dạng");
                            $(this).next().show();
                        } else {
                            $(this).removeClass("is-invalid");
                            $(this).next().hide();
                        }
                    } else {
                        $(this).next().hide();
                        $(this).removeClass("is-invalid");
                    }
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Name_RawMaterial", "Vui lòng nhập tên nguyên liệu");
            validateInput("#Unit", "Vui lòng nhập đơn vị");
            validateInput("#Count", "Vui lòng nhập số lượng");

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
