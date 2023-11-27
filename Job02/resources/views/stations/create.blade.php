@extends('layouts.master')

@section('title', 'Thêm trạm')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12 d-flex justify-content-center">
        <div class="w-50 mt-3">
          <div class="card">
            <div class="card-header p-0 overflow-hidden">
              <h3 class="card-title m-0 bg-primary-color p-3 text-white">Thêm trạm</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('stations.store') }}">
                @csrf
                <div class="form-group">
                  <label for="Id_Station" class="form-label">Mã trạm</label>
                  <input type="text" name="Id_Station" id="Id_Station" placeholder="Nhập mã trạm"
                    class="form-control{{ $errors->has('Id_Station') ? ' is-invalid' : '' }}"
                    value="{{ old('Id_Station') }}">
                  @if ($errors->has('Id_Station'))
                    <span class="text-danger">
                      {{ $errors->first('Id_Station') }}
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="Name_Station" class="form-label">Tên trạm</label>
                  <input type="text" name="Name_Station" id="Name_Station" placeholder="Nhập tên trạm"
                    class="form-control{{ $errors->has('Name_Station') ? ' is-invalid' : '' }}"
                    value="{{ old('Name_Station') }}">
                  @if ($errors->has('Name_Station'))
                    <span class="text-danger">
                      {{ $errors->first('Name_Station') }}
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="Ip_Address" class="form-label">Địa chỉ IP</label>
                  <input type="text" name="Ip_Address" id="Ip_Address" placeholder="Nhập địa chỉ IP"
                    class="form-control{{ $errors->has('Unit') ? ' is-invalid' : '' }}" value="{{ old('Id_Address') }}">
                  @if ($errors->has('Ip_Address'))
                    <span class="text-danger">
                      {{ $errors->first('Ip_Address') }}
                    </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="FK_Id_StationType" class="form-label">Loại trạm</label>
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
                  <a href="{{ route('stations.index') }}" class="btn btn-warning">Quay lại</a>
                  <button type="submit" class="btn btn-primary-color">Tạo</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
