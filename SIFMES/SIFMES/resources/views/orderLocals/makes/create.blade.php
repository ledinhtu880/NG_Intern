@extends('layouts.master')

@section('title', 'Tạo đơn sản xuất')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Thêm đơn sản xuất</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thùng hàng</h4>
          </div>
          <div class="card-body px-0">
            <div class="px-3 mb-3 d-flex justify-content-between align-items-center">
              <div class="input-group" style="width: 325px;">
                <label class="input-group-text bg-secondary-subtle" for="FK_Id_CustomerType">Loại khách hàng</label>
                <select name="FK_Id_CustomerType" id="FK_Id_CustomerType" class="form-select">
                  @foreach($customerType as $each)
                  <option value="{{ $each->Id }}">{{ $each->Name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-group" style="width: 325px;">
                <label class="input-group-text bg-secondary-subtle" for="LiquidOrSolid">Kiểu nguyên liệu</label>
                <select name="LiquidOrSolid" id="LiquidOrSolid" class="form-select">
                  <option value="1">Chất rắn</option>
                  <option value="2">Chất lỏng</option>
                </select>
              </div>
              <div class="input-group" style="width: 325px;">
                <label class="input-group-text bg-secondary-subtle" for="SimpleOrPack">Kiểu hàng</label>
                <select name="SimpleOrPack" id="SimpleOrPack" class="form-select">
                  <option value="0">Thùng hàng</option>
                  <option value="1">Gói hàng</option>
                </select>
              </div>
            </div>
            <table class="table table-striped m-0">
              <thead id="table-heading">
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Khách hàng</th>
                  <th class="text-center" scope="col">Nguyên liệu</th>
                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá thùng chứa</th>
                </tr>
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex align-content-center justify-content-between">
              <button type="submit" class="btn btn-primary-color px-3" id="addBtn">
                <i class="fa-solid fa-plus text-white me-2"></i>Thêm
              </button>
              <div class="input-group" style="width: 300px;">
                <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                  Ngày giao hàng
                </label>
                <input type="date" name="Date_Delivery" id="Date_Delivery" class="form-control"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Đơn sản xuất</h4>
          </div>
          <div class="card-body px-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Mã đơn hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Kiểu hàng</th>
                  <th class="text-center" scope="col">Ngày giao hàng</th>
                  <th class="text-center" scope="col">Mô tả</th>
                </tr>
              </thead>
              <tbody id="table-result">
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary-color px-3" id="deleteBtn">
              <i class="fa-solid fa-minus text-white me-2"></i>Xóa
            </button>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end my-3 me-3">
          <a href="{{ route('orderLocals.makes.index')}}" class="btn btn-primary-color px-4">Lưu</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex align-items-center justify-content-between">
      <div class="d-flex justify-content-center align-items-center gap-2">
        <i id="icon" class="fas text-light fs-5"></i>
        <h6 id="toast-msg" class="h6 text-white m-0"></h6>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection


@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/orderLocals/makes/create.js') }}"></script>
@endpush