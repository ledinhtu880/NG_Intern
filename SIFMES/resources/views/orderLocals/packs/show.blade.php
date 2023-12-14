@extends('layouts.master')

@section('title', 'Chi tiết đơn đóng gói')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Mã đơn đóng gói
                </h6>
                <p class="card-text">
                  {{ $orderLocal->Id_OrderLocal }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Kiểu hàng
                </h6>
                <p class="card-text">
                  {{ $orderLocal->SimpleOrPack == 0 ? 'Thùng hàng' : 'Gói hàng' }}
                </p>
              </div>
              {{-- <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày đặt hàng
                </h6>
                <p class="card-text">
                  {{ $order->order_date }}
                </p>
              </div> --}}
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày giao hàng
                </h6>
                <p class="card-text">
                  {{ $orderLocal->getDeliveryDateAttribute() }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày bắt đầu
                </h6>
                <p class="card-text">
                  {{ $orderLocal->getStartDateAttribute() }}
                </p>
              </div>
              <div class="col-md-4 mb-3">
                <h6 class="card-subtitle">
                  Ngày kết thúc
                </h6>
                <p class="card-text">
                  {{ $orderLocal->getFinallyDateAttribute() }}
                </p>
              </div>
              {{-- <div class="col-md-4">
                <h6 class="card-subtitle">
                  Ghi chú
                </h6>
                <p class="card-text">
                  {{ $order->Note }}
                </p>
              </div> --}}
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chi tiết</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered m-0">
              <thead>
                <tr>
                  <th scope="col">Nguyên liệu</th>
                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col">Đơn vị</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá thùng chứa</th>
                  <th class="text-center" scope="col">Thành tiền</th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach ($contentSimples as $each)
                <tr>
                  <td>{{ $each->material->Name_RawMaterial }}</td>
                  <td class="text-center">{{ $each->Count_RawMaterial }}</td>
                  <td class="text-center">{{ $each->material->Unit }}</td>
                  <td class="text-center">{{ $each->type->Name_ContainerType }}</td>
                  <td class="text-center">{{ $each->Count_Container }}</td>
                  <td class="text-center">
                    {{ number_format($each->Price_Container, 0, '', '') }} VNĐ
                  </td>
                  <td class="text-center">
                    {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center justify-content-end">
            <a href="{{ route('orderLocals.packs.index') }}" class="btn btn-warning">Quay lại</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection