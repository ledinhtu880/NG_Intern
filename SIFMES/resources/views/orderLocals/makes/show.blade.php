@extends('layouts.master')

@section('title', 'Hiển thị đơn sản xuất')
@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin đơn sản xuất</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Mã đơn hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->Id_OrderLocal}}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Số lượng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->Count }}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Kiểu hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->type }}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Trạng thái
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->status}}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày giao hàng
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->delivery_date}}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày bắt đầu
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->start_date}}
            </p>
          </div>
          <div class="col-md-3 mb-3">
            <h6 class="card-subtitle" style="font-weight: 600;">
              Ngày kết thúc
            </h6>
            <p class="card-text text-secondary fw-normal">
              {{ $orderLocal->finally_date}}
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
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin chi tiết</h5>
      </div>
      <div class="card-body">
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
                {{ number_format($each->Price_Container, 0, ',', '.') . ' VNĐ' }} </td>
              <td class="text-center">
                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-end">
        <a href="{{ route('orderLocals.makes.index') }}" class="btn btn-lg btn-light px-3 fs-6">Quay lại</a>
      </div>
    </div>
  </div>
</div>
@endsection