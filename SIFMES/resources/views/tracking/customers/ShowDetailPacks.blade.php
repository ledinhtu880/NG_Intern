@extends('layouts.master')
@section('title', 'Chi tiết gói hàng')

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
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin gói hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.customers.index') }}">Theo
          dõi khách hàng</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thông tin gói hàng</li>
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
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin gói hàng</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center">#</th>
              <th scope="col" class="py-3 text-center">Số lượng</th>
              <th scope="col" class="py-3 text-center">Đơn giá</th>
              <th scope="col" class="py-3 text-center">Trạng thái dây chuyền</th>
              <th scope="col" class="py-3 text-center">Hoạt động</th>
            </tr>
          </thead>
          <tbody>
            @php
            $count = 0;
            @endphp
            @foreach ($contentPacks as $contentPack)
            <tr>
              <th class="text-center">{{ $contentPack->Id_ContentPack }}</th>
              <td class="text-center">{{ $contentPack->Count_Pack }}</td>
              <td class="text-center">
                {{ number_format($contentPack->Price_Pack, 0, ',', '.') . ' VNĐ' }}
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center">
                  <div class="progress w-50 position-relative" role="progressbar"
                    aria-valuenow="{{ $percents[$count] * 100 }}" aria-valuemin="0" aria-valuemax="100"
                    style="height: 20px">
                    <div class="progress-bar bg-primary" style="width: {{ $percents[$count] * 100 }}%">
                    </div>
                    <span class="progress-text fw-bold fs-6
                        @if ($percents[$count] * 100 >= 50) text-white @else text-primary @endif
                        ">
                      {{ $percents[$count] * 100 }}%
                    </span>
                  </div>
                </div>
              </td>
              <td class="text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-outline-light text-primary border-secondary btn-detail"
                  data-bs-toggle="modal" data-id="{{ $contentPack->Id_ContentPack }}"
                  data-bs-target="#i{{ $contentPack->Id_ContentPack }}">
                  <i class="fa-solid fa-eye"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="i{{ $contentPack->Id_ContentPack }}" data-bs-backdrop="static"
                  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-dialog-centered ">
                    <div class="modal-content">
                      <div class="modal-header p-2 bg-primary text-start" data-bs-theme="dark">
                        <h5 class="modal-title w-100 " id="istaticBackdropLabel">
                          Chi tiết gói hàng
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class='table table-bordered '>
                          <thead>
                            <tr>
                              <th scope="col" class="align-middle text-center">Mã thùng hàng</th>
                              <th scope="col" class="align-middle text-center">Nguyên liệu</th>
                              <th class="text-centeralign-middle" scope="col">Đơn vị</th>
                              <th class="text-centeralign-middle" scope="col">Thùng chứa</th>
                              <th class="text-centeralign-middle" scope="col">Thành tiền</th>
                              <th class="text-centeralign-middle" scope="col">Trạng thái dây chuyền</th>
                            </tr>
                          </thead>
                          <tbody class="body-table">
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-warning " data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
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
        <a href="{{ route('tracking.customers.index') }}" class="btn btn-lg btn-primary px-4">
          Quay lại
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('javascript')
<script>
  $(document).ready(function () {
    $(".btn-detail").on('click', function () {
      let id_ContentPack = $(this).data('id');

      $.ajax({
        url: '/tracking/customers/detailSimpleOfPack',
        type: 'POST',
        data: {
          _token: $("meta[name='csrf-token']").attr('content'),
          id_ContentPack: id_ContentPack
        },
        success: function (response) {
          $(".body-table").html(response);
          console.log(response);
        },
        error: function (xhr) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>
@endpush