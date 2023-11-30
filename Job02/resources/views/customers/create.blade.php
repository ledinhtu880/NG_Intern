@extends('layouts.master')

@section('title', 'Thêm khách hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('customers.index') }}">Quản lý khách hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Thêm khách hàng</li>
          </ol>
        </nav>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h3 class="card-title m-0 bg-primary-color p-3 text-white">Thêm khách hàng</h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('customers.store') }}">
              @csrf
              <div class="form-group">
                <label for="Name_Customer" class="form-label">Tên khách hàng</label>
                <input type="text" name="Name_Customer" id="Name_Customer" placeholder="Nhập tên khách hàng"
                  class="form-control{{ $errors->has('Name_Customer') ? ' is-invalid' : '' }}"
                  value="{{ old('Name_Customer') }}">
                @if ($errors->has('Name_Customer'))
                <span class="text-danger">
                  {{ $errors->first('Name_Customer') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Email" class="form-label">Email</label>
                <input type="text" name="Email" id="Email" placeholder="Nhập email"
                  class="form-control{{ $errors->has('Email') ? ' is-invalid' : '' }}" value="{{ old('Email') }}">
                @if ($errors->has('Email'))
                <span class="text-danger">
                  {{ $errors->first('Email') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Phone" class="form-label">Phone</label>
                <input type="text" name="Phone" id="Phone" placeholder="Nhập số điện thoại"
                  class="form-control{{ $errors->has('Phone') ? ' is-invalid' : '' }}" value="{{ old('Phone') }}">
                @if ($errors->has('Phone'))
                <span class="text-danger">
                  {{ $errors->first('Phone') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Name_Contact" class="form-label">Tên liên hệ</label>
                <input type="text" name="Name_Contact" id="Name_Contact" placeholder="Nhập tên liên hệ"
                  class="form-control{{ $errors->has('Name_Contact') ? ' is-invalid' : '' }}"
                  value="{{ old('Name_Contact') }}">
                @if ($errors->has('Name_Contact'))
                <span class="text-danger">
                  {{ $errors->first('Name_Contact') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Address" class="form-label">Địa chỉ</label>
                <input type="text" name="Address" id="Address" placeholder="Nhập địa chỉ"
                  class="form-control{{ $errors->has('Address') ? ' is-invalid' : '' }}" value="{{ old('Address') }}">
                @if ($errors->has('Address'))
                <span class="text-danger">
                  {{ $errors->first('Address') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Zipcode" class="form-label">Zipcode</label>
                <input type="number" name="Zipcode" id="zipcode" placeholder="Nhập zipcode"
                  class="form-control{{ $errors->has('Zipcode') ? ' is-invalid' : '' }}" value="{{ old('Zipcode') }}">
                @if ($errors->has('Zipcode'))
                <span class="text-danger">
                  {{ $errors->first('Zipcode') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="Time_Reception" class="form-label">Thời gian nhận</label>
                <input type="date" name="Time_Reception" id="Time_Reception"
                  class="form-control{{ $errors->has('Time_Reception') ? ' is-invalid' : '' }}"
                  value="{{ old('Time_Reception') }}">
                @if ($errors->has('Time_Reception'))
                <span class="text-danger">
                  {{ $errors->first('Time_Reception') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="FK_Id_Mode_Transport" class="form-label">Phương thức vận chuyển</label>
                <select name="FK_Id_Mode_Transport"
                  class="form-select{{ $errors->has('FK_Id_Mode_Transport') ? ' is-invalid' : '' }}">
                  <option value="">Chọn phương thức vận chuyển</option>
                  @foreach ($data as $each)
                  <option value="{{ $each->Id_ModeTransport }}">{{ $each->Name_ModeTransport }}
                  </option>
                  @endforeach
                </select>
                @if ($errors->has('FK_Id_Mode_Transport'))
                <span class="text-danger">
                  {{ $errors->first('FK_Id_Mode_Transport') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="FK_Id_CustomerType" class="form-label">Chọn kiểu khách hàng</label>
                <select name="FK_Id_CustomerType"
                  class="form-select{{ $errors->has('FK_Id_CustomerType') ? ' is-invalid' : '' }}">
                  <option value="">Chọn kiểu khách hàng</option>
                  @foreach ($customerTypes as $each)
                  <option value="{{ $each->Id }}">{{ $each->Name }}
                  </option>
                  @endforeach
                </select>
                @if ($errors->has('FK_Id_CustomerType'))
                <span class="text-danger">
                  {{ $errors->first('FK_Id_CustomerType') }}
                </span>
                @endif
              </div>
              <div class="d-flex justify-content-end my-4 gap-3">
                <a href="{{ route('customers.index') }}" class="btn btn-warning">Quay lại</a>
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