@extends('layouts.master')

@section('title', 'Theo dõi khách hàng')

@push('css')
<style>
  .progress-text {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  }
</style>
@endpush
@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Theo dõi khách hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi khách hàng</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="w-25">
      <div class="input-group">
        <label for="" class="input-group-text">Chọn khách hàng</label>
        <select name="" id="customer_selected" class="form-select">
          @foreach ($customers as $customer)
          <option value="{{ $customer->Id_Customer }}">{{ $customer->Name_Customer }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">
          <i class="fa-solid fa-user me-2"></i>
          Thông tin khách hàng
        </h5>
      </div>
      <div class="card-body" id="customer-infor">
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">
          <i class="fa-solid fa-train me-2"></i>
          Thông tin đóng gói và vận chuyển của khách hàng
        </h5>
      </div>
      <div class="card-body" id="pack-transport">
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">
          <i class="fa-solid fa-list-ul me-2"></i>
          Bảng đơn đặt hàng của khách hàng
        </h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center">#</th>
              <th scope="col" class="py-3 text-center">Ngày đặt hàng</th>
              <th scope="col" class="py-3 text-center">Ngày giao hàng</th>
              <th scope="col" class="py-3 text-center">Trạng thái</th>
              <th scope="col" class="py-3 text-center">Trạng thái sản phẩm</th>
              <th scope="col" class="py-3 text-center">Kiểu hàng</th>
              <th scope="col" class="py-3 text-center">Xem</th>
            </tr>
          </thead>
          <tbody class="order-infor">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@push('javascript')
<script>

</script>
<script type="text/javascript" src="{{ asset('js/customer/InforCustomer.js') }}"></script>
@endpush