@extends('layouts.master')

@section('title', 'Sửa nguyên liệu thô')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50 mt-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item">
              <a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
              <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa nguyên liệu thô</li>
          </ol>
        </nav>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Sửa nguyên liệu thô</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('rawMaterials.update', $material->Id_RawMaterial ) }}">
              @csrf
              @method('PUT')
              <div class="form-group">
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
              <div class="form-group">
                <label for="Unit" class="form-label">Đơn vị</label>
                <input type="text" name="Unit" id="Unit" placeholder="Nhập đơn vị" value="{{ $material->Unit}}"
                  class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}">
                @if ($errors->has('Unit'))
                <span class="text-danger">
                  {{ $errors->first('Unit') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Count" class="form-label">Số lượng</label>
                <input type="number" name="Count" id="Count" placeholder="Nhập số lượng" value="{{ $material->Count }}"
                  class="form-control{{ $errors->has('Count') ? ' is-invalid' : '' }}">
                @if ($errors->has('Count'))
                <span class="text-danger">
                  {{ $errors->first('Count') }}
                </span>
                @endif
              </div>
              <div class="form-group">
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
              <div class="d-flex justify-content-end my-4 gap-3">
                <a href="{{ route('rawMaterials.index') }}" class="btn btn-warning">Quay lại</a>
                <button type="button" class="btn btn-primary-color" data-bs-toggle="modal"
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
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary-color">Xác nhận</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection