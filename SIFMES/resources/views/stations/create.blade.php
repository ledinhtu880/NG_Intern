@extends('layouts.master')

@section('title', 'Thêm trạm')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thêm trạm</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('stations.index') }}">Quản lý trạm</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form method="POST" action="{{ route('stations.store') }}">
          @csrf
          <div class="d-flex gap-2">
            <div class="form-group" style="flex: 1;">
              <label for="Id_Station" class="form-label" style="font-weight: 600;">Mã trạm</label>
              <input type="text" name="Id_Station" id="Id_Station" placeholder="Nhập mã trạm"
                class="form-control{{ $errors->has('Id_Station') ? ' is-invalid' : '' }}"
                value="{{ old('Id_Station') }}">
              @if ($errors->has('Id_Station'))
              <span class="text-danger">
                {{ $errors->first('Id_Station') }}
              </span>
              @endif
            </div>
            <div class="form-group" style="flex: 1;">
              <label for="Name_Station" class="form-label" style="font-weight: 600;">Tên trạm</label>
              <input type="text" name="Name_Station" id="Name_Station" placeholder="Nhập tên trạm"
                class="form-control{{ $errors->has('Name_Station') ? ' is-invalid' : '' }}"
                value="{{ old('Name_Station') }}">
              @if ($errors->has('Name_Station'))
              <span class="text-danger">
                {{ $errors->first('Name_Station') }}
              </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="Ip_Address" class="form-label" style="font-weight: 600;">Địa chỉ IP</label>
            <input type="text" name="Ip_Address" id="Ip_Address" placeholder="Nhập địa chỉ IP"
              class="form-control{{ $errors->has('Ip_Address') ? ' is-invalid' : '' }}" value="{{ old('Ip_Address') }}">
            @if ($errors->has('Ip_Address'))
            <span class="text-danger">
              {{ $errors->first('Ip_Address') }}
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="FK_Id_StationType" class="form-label" style="font-weight: 600;">Loại trạm</label>
            <select name="FK_Id_StationType"
              class="form-select{{ $errors->has('FK_Id_StationType') ? ' is-invalid' : '' }}">
              <option value="">Chọn loại trạm</option>
              @foreach ($data as $each)
              <option value="{{ $each->Id_StationType }}">{{ $each->Name_StationType }}</option>
              @endforeach
            </select>
            @if ($errors->has('FK_Id_StationType'))
            <span class="text-danger">
              {{ $errors->first('FK_Id_StationType') }}
            </span>
            @endif
          </div>
          <div class="d-flex justify-content-end my-4 gap-3">
            <a href="{{ route('stations.index') }}" class="btn btn-light">Quay lại</a>
            <button type="submit" class="btn btn-primary">Tạo</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection