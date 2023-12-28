@extends('layouts.master')

@section('title', 'Sửa đơn đóng gói')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orderLocals.packs.index') }}">Quản lý đơn đóng gói</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa đơn sản xuất</li>
          </ol>
        </nav>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Sửa thông tin đơn đóng gói</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('orderLocals.packs.update', $orderLocal) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="input-group">
                    <label for="" class="input-group-text">Mã đơn đóng gói</label>
                    <input type="text" name='Id_OrderLocal' class="form-control " readonly disabled
                      value="{{ $orderLocal->Id_OrderLocal }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <label for="" class="input-group-text">Ngày giao hàng</label>
                    <input type="date" class="form-control" name="Date_Delivery"
                      value="{{ Carbon\Carbon::parse($orderLocal->Date_Delivery)->format('Y-m-d') }}">
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="input-group">
                    <label for="" class="input-group-text">Ngày bắt đầu</label>
                    <input type="date" class="form-control " name="Date_Start"
                      value="{{ Carbon\Carbon::parse($orderLocal->Date_Start)->format('Y-m-d') }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <label for="" class="input-group-text">Số lượng</label>
                    <input type="number" min='1' class="form-control" name="Count" value="{{ $orderLocal->Count }}">
                  </div>
                </div>
              </div>
              <div class="mt-3 d-flex align-items-center justify-content-end gap-3">
                <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-warning">Quay lại</a>
                <button type="submit" class="btn btn-primary-color px-4">Lưu</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection