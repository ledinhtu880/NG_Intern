@extends('layouts.master')

@section('title', 'Tạo nguyên liệu thô')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Thêm nguyên liệu thô
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                        <form id="formInformation" method="POST" action="{{ route('rawMaterials.store') }}">
                            @csrf
                            <div class="d-flex gap-2">
                                <div class="form-group mb-3" style="flex: 1">
                                    <label for="Name_RawMaterial" class="form-label">Tên nguyên
                                        liệu</label>
                                    <input type="text" name="Name_RawMaterial" id="Name_RawMaterial"
                                        placeholder="Nhập tên nguyên liệu thô"
                                        class="form-control{{ $errors->has('Name_RawMaterial') ? ' is-invalid' : '' }}"
                                        value="{{ old('Name_RawMaterial') }}">
                                    @if ($errors->has('Name_RawMaterial'))
                                        <span class="text-danger">
                                            {{ $errors->first('Name_RawMaterial') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group mb-3" style="flex: 1">
                                    <label for="Unit" class="form-label">Đơn vị</label>
                                    <input type="text" name="Unit" id="Unit" placeholder="Nhập đơn vị"
                                        class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}"
                                        value="{{ old('Unit') }}">
                                    @if ($errors->has('Unit'))
                                        <span class="text-danger">
                                            {{ $errors->first('Unit') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="form-group" style="flex: 1">
                                    <label for="Count" class="form-label">Số lượng</label>
                                    <input type="number" name="Count" id="Count" placeholder="Nhập số lượng"
                                        class="form-control{{ $errors->has('Count') ? ' is-invalid' : '' }}"
                                        value="{{ old('Count') }}">
                                    @if ($errors->has('Count'))
                                        <span class="text-danger">
                                            {{ $errors->first('Count') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group" style="flex: 1">
                                    <label for="FK_Id_RawMaterialType" class="form-label">Loại
                                        nguyên
                                        liệu</label>
                                    <select name="FK_Id_RawMaterialType"
                                        class="form-select{{ $errors->has('FK_Id_RawMaterialType') ? ' is-invalid' : '' }}">
                                        @foreach ($data as $each)
                                            <option value="{{ $each->id }}">
                                                {{ $each->Name_RawMaterialType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('FK_Id_RawMaterialType'))
                                        <span class="text-danger">
                                            {{ $errors->first('FK_Id_RawMaterialType') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('rawMaterials.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            $('#saveBtn').click(function(e) {
                $('#formInformation').submit();
            });
        })
    </script>
@endpush
