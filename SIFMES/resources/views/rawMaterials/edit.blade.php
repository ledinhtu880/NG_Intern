@extends('layouts.master')

@section('title', 'Sửa nguyên liệu thô')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thêm nguyên liệu thô</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex flex-column justify-content-between h-100">
        <form id="formInformation" method="POST"
          action="{{ route('rawMaterials.update', $material->Id_RawMaterial ) }}">
          @csrf
          @method('PUT')
          <div class="d-flex gap-2">
            <div class="form-group" style="flex: 1;">
              <label for="Name_RawMaterial" class="form-label">Tên nguyên liệu</label>
              <input type="text" name="Name_RawMaterial" id="Name_RawMaterial" placeholder="Nhập tên nguyên liệu thô"
                value="{{ $material->Name_RawMaterial}}"
                class="form-control{{ $errors->has('Name_RawMaterial') ? ' is-invalid' : '' }}">
              @if ($errors->has('Name_RawMaterial'))
              <span class="text-danger">
                {{ $errors->first('Name_RawMaterial') }}
              </span>
              @endif
            </div>
            <div class="form-group" style="flex: 1;">
              <label for="Unit" class="form-label">Đơn vị</label>
              <input type="text" name="Unit" id="Unit" placeholder="Nhập đơn vị" value="{{ $material->Unit}}"
                class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}">
              @if ($errors->has('Unit'))
              <span class="text-danger">
                {{ $errors->first('Unit') }}
              </span>
              @endif
            </div>
          </div>
          <div class="d-flex gap-2">
            <div class="form-group" style="flex: 1;">
              <label for="Count" class="form-label">Số lượng</label>
              <input type="number" name="Count" id="Count" placeholder="Nhập số lượng" value="{{ $material->Count }}"
                class="form-control{{ $errors->has('Count') ? ' is-invalid' : '' }}">
              @if ($errors->has('Count'))
              <span class="text-danger">
                {{ $errors->first('Count') }}
              </span>
              @endif
            </div>
            <div class="form-group" style="flex: 1;">
              <label for="FK_Id_RawMaterialType" class="form-label">Loại nguyên liệu</label>
              <select name="FK_Id_RawMaterialType"
                class="form-select{{ $errors->has('FK_Id_RawMaterialType') ? ' is-invalid' : '' }}">
                @foreach($data as $each)
                @if($each->id == $material->FK_Id_RawMaterialType)
                <option value="{{ $each->id }}" selected>{{ $each->Name_RawMaterialType }}
                </option>
                @else
                <option value="{{ $each->id }}">{{ $each->Name_RawMaterialType }}</option>
                @endif
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
      <div class="card-footer">
        <div class="d-flex justify-content-end gap-3">
          <a href="{{ route('rawMaterials.index') }}" class="btn btn-light">Quay lại</a>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#deleteOrder-{{ $material->Id_RawMaterial }}">
            Cập nhật
          </button>
          <div class="modal fade" id="deleteOrder-{{ $material->Id_RawMaterial }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Bạn có chắc chắn muốn cập nhật nguyên liệu thô này?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-primary">Xác nhận</button>
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
<script>
  $(document).ready(function () {
    $("#saveBtn").on('click', function () {
      $("#formInformation").submit();
    })
  })
</script>
@endpush