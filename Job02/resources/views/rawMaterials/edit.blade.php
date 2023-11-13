@extends('layouts.master')

@section('title', 'Sửa nguyên liệu thô')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50 mt-3">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h3 class="card-title m-0 bg-secondary-subtle p-3 text-primary-color">Sửa nguyên liệu thô</h3>
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
                <label for="count" class="form-label">Số lượng</label>
                <input type="number" name="count" id="count" placeholder="Nhập số lượng" value="{{ $material->count}}"
                  class="form-control{{ $errors->has('count') ? ' is-invalid' : '' }}">
                @if ($errors->has('count'))
                <span class="text-danger">
                  {{ $errors->first('count') }}
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
                <button type="submit" class="btn btn-success">Cập nhật</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection