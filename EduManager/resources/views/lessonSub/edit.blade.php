@extends('layouts.master')

@section('title', 'Thêm môn học')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h3 class="h3 fw-medium">Thêm môn học</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}" class="text-decoration-none fw-medium">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('eduProgram.index') }}" class="text-decoration-none fw-medium">Quản lý đào tạo</a>
                </li>
                <li class="breadcrumb-item fw-medium active" aria-current="page">Thêm</li>
            </ol>
        </nav>
    </div>
    <div class="row g-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <form id="formInformation" method="POST" action="{{ route('eduProgram.store') }}"
                        class="d-flex flex-column gap-2">
                        @csrf
                        <div class="d-flex gap-2">
                            <div class="form-group" style="flex: 1">
                                <label for="Sym_Sub" class="form-label">Ký hiệu môn học</label>
                                <input type="text" name="Sym_Sub" id="Sym_Sub"
                                    class="form-control{{ $errors->has('Sym_Sub') ? ' is-invalid' : '' }}"
                                    value="{{ old('Sym_Sub') }}" placeholder="Nhập ký hiệu môn học" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('Sym_Sub'))
                                        {{ $errors->first('Sym_Sub') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group" style="flex: 1">
                                <label for="Name_Sub" class="form-label">Tên môn học</label>
                                <input type="text" name="Name_Sub" id="Name_Sub"
                                    class="form-control{{ $errors->has('Name_Sub') ? ' is-invalid' : '' }}"
                                    value="{{ old('Name_Sub') }}" placeholder="Nhập tên môn học" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('Name_Sub'))
                                        {{ $errors->first('Name_Sub') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-4">
                            <div class="form-group" style="flex: 1">
                                <label for="Theory" class="form-label">Lý thuyết</label>
                                <input type="number" name="Theory" id="Theory"
                                    class="form-control{{ $errors->has('Theory') ? ' is-invalid' : '' }}" value="0"
                                    min="0" tabindex="3">
                                <span class="text-danger">
                                    @if ($errors->has('Theory'))
                                        {{ $errors->first('Theory') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group" style="flex: 1">
                                <label for="Exercise" class="form-label">Bài tập</label>
                                <input type="number" name="Exercise" id="Exercise"
                                    class="form-control{{ $errors->has('Exercise') ? ' is-invalid' : '' }}" value="0"
                                    min="0" tabindex="4">
                                <span class="text-danger">
                                    @if ($errors->has('Exercise'))
                                        {{ $errors->first('Exercise') }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group" style="flex: 1">
                                <label for="Practice" class="form-label">Thực hành</label>
                                <input type="number" name="Practice" id="Practice"
                                    class="form-control{{ $errors->has('Practice') ? ' is-invalid' : '' }}" value="0"
                                    min="0" tabindex="5">
                                <span class="text-danger">
                                    @if ($errors->has('Practice'))
                                        {{ $errors->first('Practice') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('eduProgram.index') }}" class="btn btn-secondary" tabindex="10">Quay lại</a>
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
                    $(this).addClass("is-invalid");
                    $(this).next().text(message);
                    $(this).next().show();
                } else {
                    if ($(this).attr("id") == "Sym_Sub") {
                        if (!/^[a-zA-Z0-9,-]+$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng chỉ nhập ký tự chữ và số.");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "Name_Sub") {
                        if (!/^[\w\W\s\d-,]*$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).next().text("Vui lòng chỉ nhập ký tự chữ và số.");
                            $(this).next().show();
                        } else {
                            $(this).next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "Theory" || $(this).attr("id") == "Exercise" || $(this).attr(
                            "id") == "Practice") {
                        if ($(this).val() < 0) {
                            console.log($(this).next());
                            $(this).addClass("is-invalid");
                            $(this).next().text("Số giờ học phải lớn hơn 0");
                            $(this).next().show();
                        } else {
                            $(this).removeClass("is-invalid");
                            $(this).next().hide();
                        }
                    }
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Sym_Sub", "Vui lòng nhập ký hiệu môn học");
            validateInput("#Name_Sub", "Vui lòng nhập tên môn học");
            validateInput("#Theory");
            validateInput("#Exercise");
            validateInput("#Practice");

            $("#saveBtn").on('click', function() {
                let isValid = true;

                $(".form-control").each(function(element) {
                    if ($(this).hasClass("is-invalid")) {
                        isValid = false;
                    } else if ($(this).val() == "") {
                        isValid = false;
                        $(this).next().text("Trường này là bắt buộc");
                        $(this).addClass("is-invalid");
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
