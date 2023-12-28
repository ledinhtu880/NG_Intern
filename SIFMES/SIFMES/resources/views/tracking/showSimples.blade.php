@extends('layouts.master')

@section('title', 'Chi tiết đơn thùng hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('tracking.orders.index') }}">Theo dõi đơn hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết đơn thùng hàng</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Mã đơn hàng
                </h6>
                <p class="card-text">
                  {{ $order->Id_Order }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Tên khách hàng
                </h6>
                <p class="card-text">
                  {{ $order->customer->Name_Customer }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày đặt hàng
                </h6>
                <p class="card-text">
                  {{ $order->order_date }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày giao hàng
                </h6>
                <p class="card-text">
                  {{ $order->delivery_date }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày nhận hàng
                </h6>
                <p class="card-text">
                  {{ $order->reception_date }}
                </p>
              </div>
              <div class="col-md-4">
                <h6 class="card-subtitle">
                  Ghi chú
                </h6>
                <p class="card-text">
                  {{ $order->Note }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin thùng hàng</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered m-0">
              <thead>
                <tr class="text-center align-middle">
                  <th scope="col">Mã thùng hàng</th>
                  <th scope="col">Nguyên liệu</th>
                  <th scope="col">Đơn vị</th>
                  <th scope="col">Thùng chứa</th>
                  <th scope="col">Thành tiền</th>
                  <th scope="col">Trạng thái dây chuyền</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach ($data as $each)
                <tr class="text-center align-middle">
                  <td>{{ $each->Id_ContentSimple }}</td>
                  <td>{{ $each->Name_RawMaterial }}</td>
                  <td>{{ $each->Unit }}</td>
                  <td>{{ $each->Name_ContainerType }}</td>
                  <td>{{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}</td>
                  <td>
                    @if($each->progress == 'Chưa có thông tin')
                    <p>{{ $each->progress }}</p>
                    @else
                    <div class="d-flex justify-content-center">
                      <div class="progress w-50 position-relative" role="progressbar"
                        aria-valuenow="{{ $each->progress }}" aria-valuemin="0" aria-valuemax="100"
                        style="height: 20px">
                        <div class="progress-bar bg-primary-color" style="width: {{ $each->progress }}%">
                        </div>
                        <span
                          class="progress-text fw-bold fs-6 {{$each->progress > 35 ? 'text-white' : 'text-primary-color'}}">
                          {{ $each->progress }}%
                        </span>
                      </div>
                    </div>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('tracking.showDetailsSimple', $each->Id_ContentSimple) }}"
                      class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center justify-content-end mt-3">
            <a href="{{ route('tracking.orders.index') }}" class="btn btn-lg btn-primary-color px-4">
              Quay lại
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection