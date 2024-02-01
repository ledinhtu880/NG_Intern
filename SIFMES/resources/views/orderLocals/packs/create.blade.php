@extends('layouts.master')

@section('title', 'Tạo đơn đóng gói')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Tạo đơn đóng gói</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orderLocals.packs.index') }}">Quản lý đơn đóng gói</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h4 class="card-title m-0 fw-bold text-body-secondary">Gói hàng</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="input-group" style="width: 325px;">
            <label class="input-group-text bg-secondary-subtle" for="FK_Id_CustomerType">
              Loại khách hàng
            </label>
            <select name="FK_Id_CustomerType" id="FK_Id_CustomerType" class="form-select">
              @foreach ($customerType as $each)
              <option value="{{ $each->Id }}">{{ $each->Name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <table class="table mt-4">
          <thead class="table-light" id="table-heading">
            <tr>
              <th scope="col" class="py-3 text-center">Chọn</th>
              <th scope="col" class="py-3 text-center">Mã gói hàng</th>
              <th scope="col" class="py-3 text-center">Mã đơn hàng</th>
              <th scope="col" class="py-3">Khách hàng</th>
              <th scope="col" class="py-3 text-center">Số lượng gói hàng</th>
              <th scope="col" class="py-3 text-center">Giá gói hàng</th>
            </tr>
          </thead>
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
        <h4 class="card-title m-0 fw-bold text-body-secondary">Đơn đóng gói</h5>
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
              <th scope="col" class="py-3 text-center">Hoạt động</th>
            </tr>
          </thead>
          <tbody id="table-result">

          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-between">
        <button type="submit" class="btn btn-primary px-3" id="deleteBtn">
          <i class="fa-solid fa-minus text-white me-2"></i>Xóa
        </button>
        <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-light">Quay lại</a>
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
<script src="{{ asset('js/orderLocals/packs/create.js') }}"></script>
@endpush