@extends('layouts.master')

@section('title', 'Chi tiết đơn thùng hàng')
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
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.customers.index') }}">Theo
          dõi khách hàng</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thông tin thùng hàng</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Mã đơn hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->Id_Order }}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Tên khách hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->customer->Name_Customer }}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày đặt hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->order_date }}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày giao hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->delivery_date }}
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày nhận hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->reception_date }}
            </p>
          </div>
          <div class="col-md-4">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ghi chú
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $order->Note }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">

    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center align-middle">#</th>
              <th scope="col" class="py-3">Nguyên liệu</th>
              <th scope="col" class="py-3">Đơn vị</th>
              <th scope="col" class="py-3">Thùng chứa</th>
              <th scope="col" class="py-3 text-center align-middle">Thành tiền</th>
              <th scope="col" class="py-3 text-center align-middle">Trạng thái dây chuyền</th>
            </tr>
          </thead>
          <tbody id="table-data">
            @php
            $count = 0;
            @endphp
            @foreach ($data as $each)
            <tr>
              <td class="text-center align-middle">{{ $each->Id_ContentSimple }}</td>
              <td>{{ $each->material->Name_RawMaterial }}</td>
              <td>{{ $each->material->Unit }}</td>
              <td>{{ $each->type->Name_ContainerType }}</td=>
              <td class="text-center align-middle">
                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
              </td>
              <td class="text-center align-middle">
                <div class="d-flex justify-content-center">
                  <div class="progress w-50 position-relative" role="progressbar"
                    aria-valuenow="{{ $station_currents[$count] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"
                    style="height: 20px">
                    <div class="progress-bar bg-primary" style="width: {{ $station_currents[$count] ?? 0 }}%">
                    </div>
                    <span class="progress-text fw-bold fs-6
                          @if (isset($station_currents[$count]) && $station_currents[$count] >= 45) text-white
                          @else text-primary @endif
                        ">
                      {{ $station_currents[$count] ?? 0 }}%
                    </span>
                  </div>
                </div>
              </td>
            </tr>
            @php
            $count++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-end mt-3">
        <a href="{{ route('tracking.customers.index') }}" class="btn btn-primary">
          Quay lại
        </a>
      </div>
    </div>
  </div>
</div>
@endsection