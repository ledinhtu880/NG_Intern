@extends('layouts.master')

@section('title', 'Tạo đơn sản xuất')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Tạo đơn sản xuất</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thùng hàng</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
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
        <table class="table mt-4">
          <thead class="table-light" id="table-heading">
            <tr>
              <th scope="col" class="py-3">Chọn</th>
              <th scope="col" class="py-3">Khách hàng</th>
              <th scope="col" class="py-3">Nguyên liệu</th>
              <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
              <th scope="col" class="py-3">Thùng chứa</th>
              <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
              <th scope="col" class="py-3 text-center">Đơn giá thùng chứa</th>
            </tr>
          </thead class="table-light">
          <tbody id="table-data">
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="d-flex align-content-center justify-content-between">
          <button type="submit" class="btn btn-primary px-3" id="addBtn">
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
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Đơn sản xuất</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center">Chọn</th>
              <th scope="col" class="py-3 text-center">Mã đơn hàng</th>
              <th scope="col" class="py-3 text-center">Số lượng</th>
              <th scope="col" class="py-3">Kiểu hàng</th>
              <th scope="col" class="py-3 text-center">Ngày giao hàng</th>
              <th scope="col" class="py-3">Mô tả</th>
            </tr>
          </thead class="table-light">
          <tbody id="table-result">
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-between">
        <button type="submit" class="btn btn-primary px-3" id="deleteBtn">
          <i class="fa-solid fa-minus text-white me-2"></i>Xóa
        </button>
        <a href="{{ route('orderLocals.makes.index')}}" class="btn btn-lg btn-light px-3 fs-6">Quay lại</a>
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