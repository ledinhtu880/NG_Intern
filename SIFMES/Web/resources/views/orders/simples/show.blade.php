@extends('layouts.master')

@section('title', 'Chi tiết đơn thùng hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin đơn thùng hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý đơn thùng hàng</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Mã đơn hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->Id_Order}}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Tên khách hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->customer->Name_Customer}}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày đặt hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->order_date}}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày giao hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->delivery_date}}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày nhận hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->reception_date}}
            </p>
          </div>
          <div class="col-md-4">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ghi chú
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->Note == null ? 'Chưa có ghi chú' : $order->Note}}
            </p>
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
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h5>
      </div>
      <div class="card-body border-0">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center">#</th>
              <th scope="col" class="py-3">Nguyên liệu</th>
              <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
              <th scope="col" class="py-3">Đơn vị</th>
              <th scope="col" class="py-3">Thùng chứa</th>
              <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
              <th scope="col" class="py-3 text-center">Đơn giá thùng chứa</th>
              <th scope="col" class="py-3 text-center">Trạng thái</th>
              <th scope="col" class="py-3 text-center">Thành tiền</th>
            </tr>
          </thead>
          <tbody id="table-data">
            @foreach($data as $each)
            <tr>
              <th scope="row" class="text-center text-body-secondary">{{ $each->Id_ContentSimple}}</th>
              <td>{{ $each->Name_RawMaterial}}</td>
              <td class="text-center">{{ $each->Count_RawMaterial}}</td>
              <td>{{ $each->Unit}}</td>
              <td>{{ $each->Name_ContainerType}}</td>
              <td class="text-center">{{ $each->Count_Container}}</td>
              <td class="text-center">
                {{ number_format($each->Price_Container, 0, ',', '.'). ' VNĐ' }} </td>
              <td>
                <span class="badge text-bg-primary fw-normal fs-6">{{ $each->Status }}</span>
              </td>
              <td class="text-center">
                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.'). ' VNĐ' }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-end">
        <a href="{{ route('orders.simples.index') }}" class="btn btn-light">Quay lại</a>
      </div>
    </div>
  </div>
</div>


@endsection