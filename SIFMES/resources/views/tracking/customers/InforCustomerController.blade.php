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
  <div class="container mb-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Theo dõi khách hàng</li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-md-12">
        <div class="w-25">
          <div class="input-group">
            <label for="" class="input-group-text bg-primary-color p-2">Chọn khách hàng</label>
            <select name="" id="customer_selected" class="form-select">
              @foreach ($customers as $customer)
                <option value="{{ $customer->Id_Customer }}">{{ $customer->Name_Customer }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3 d-flex align-items-center gap-2">
              <i class="fa-solid fa-user fs-6"></i>
              Thông tin khách hàng
            </h4>
          </div>
          <div class="card-body " id="customer-infor">

          </div>
        </div>
        <div class="card mt-3">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3 d-flex align-items-center gap-2">
              <i class="fa-solid fa-train fs-6"></i>
              Thông tin đóng gói và vận chuyển của khách hàng
            </h4>
          </div>
          <div class="card-body " id="pack-transport">
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3 d-flex align-items-center gap-2">
              <i class="fa-solid fa-list-ul fs-6"></i>
              Bảng đơn đặt hàng của khách hàng
            </h4>
          </div>
          <div class="card-body ">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">Mã đơn hàng</th>
                  <th class="text-center">Ngày đặt hàng</th>
                  <th class="text-center">Ngày giao hàng</th>
                  <th class="text-center">Trạng thái</th>
                  <th class="text-center">Trạng thái sản phẩm</th>
                  <th class="text-center">Kiểu hàng</th>
                  <th class="text-center">Xem</th>
                </tr>
              </thead>
              <tbody class="order-infor">
              </tbody>
            </table>
          </div>
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
