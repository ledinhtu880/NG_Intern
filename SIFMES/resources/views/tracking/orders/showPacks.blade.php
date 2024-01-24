@extends('layouts.master')
@section('title', 'Chi tiết đơn gói hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin chi tiết gói hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.orders.index') }}">Theo dõi
          đơn hàng</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">
        Xem chi tiết
      </li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h4>
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
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin gói hàng</h4>
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
            @foreach ($data as $each)
            <tr>
              <th class="text-center ">{{ $each->Id_ContentPack }}</th>
              <td class="text-center ">{{ $each->Count_Pack }}</td>
              <td class="text-center ">
                {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center">
                  <div class="progress w-50 position-relative" role="progressbar" aria-valuenow="{{ $each->progress }}"
                    aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                    <div class="progress-bar bg-primary" style="width: {{ $each->progress }}%">
                    </div>
                    <span class="progress-text fw-bold fs-6 
                      {{ $each->progress > 35 ? 'text-white' : 'text-primary'}}">
                      {{ $each->progress }}%
                    </span>
                  </div>
                </div>
              </td>
              <td class="text-center ">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm text-secondary btn-detail" data-bs-toggle="modal"
                  data-id="{{ $each->Id_ContentPack }}" data-bs-target="#i{{ $each->Id_ContentPack }}">
                  <i class="fa-solid fa-eye"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="i{{ $each->Id_ContentPack }}" data-bs-backdrop="static"
                  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered ">
                    <div class="modal-content">
                      <div class="modal-header" data-bs-theme="dark">
                        <h5 class="modal-title fw-bold text-secondary" id="istaticBackdropLabel">
                          Chi tiết gói hàng
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class='table'>
                          <thead class="table-light">
                            <tr>
                              <th scope="col" class="py-3">Nguyên liệu</th>
                              <th scope="col" class="py-3">Số lượng nguyên liệu</th>
                              <th scope="col" class="py-3">Đơn vị</th>
                              <th scope="col" class="py-3">Thùng chứa</th>
                              <th scope="col" class="py-3">Số lượng thùng chứa</th>
                              <th scope="col" class="py-3">Đơn giá</th>
                            </tr>
                          </thead>
                          <tbody class="body-table">
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex align-items-center justify-content-end mt-3">
        <a href="{{ route('tracking.orders.index') }}" class="btn btn-light">
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
        url: '/orders/packs/showPacksDetails',
        type: 'POST',
        data: {
          _token: $("meta[name='csrf-token']").attr('content'),
          id_ContentPack: id_ContentPack
        },
        success: function (response) {
          $(".body-table").html(response);
        }
      });
    });
  });
</script>
@endpush