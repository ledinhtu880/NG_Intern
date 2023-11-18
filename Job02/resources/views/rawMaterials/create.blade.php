@extends('layouts.master')

@section('title', 'Tạo nguyên liệu thô')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50 mt-3">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thêm nguyên liệu thô</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('rawMaterials.store') }}">
              @csrf
              <div class="form-group">
                <label for="Name_RawMaterial" class="form-label">Tên nguyên liệu</label>
                <input type="text" name="Name_RawMaterial" id="Name_RawMaterial" placeholder="Nhập tên nguyên liệu thô"
                  class="form-control{{ $errors->has('Name_RawMaterial') ? ' is-invalid' : '' }}">
                @if ($errors->has('Name_RawMaterial'))
                <span class="text-danger">
                  {{ $errors->first('Name_RawMaterial') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Unit" class="form-label">Đơn vị</label>
                <input type="text" name="Unit" id="Unit" placeholder="Nhập đơn vị"
                  class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}">
                @if ($errors->has('Unit'))
                <span class="text-danger">
                  {{ $errors->first('Unit') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Count" class="form-label">Số lượng</label>
                <input type="number" name="Count" id="Count" placeholder="Nhập số lượng"
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
                  <option value="default">Chọn loại nguyên liệu</option>
                  @foreach($data as $each)
                  <option value="{{ $each->id }}">{{ $each->Name_RawMaterialType }}</option>
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
                <button type="submit" class="btn btn-primary-color">Lưu</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection