@extends('layouts.master')
@section('title', 'Chi tiết đơn gói hàng')

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
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết đơn gói hàng</li>
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
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin gói hàng</h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Mã gói hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center" scope="col">Trạng thái dây chuyền</th>
                  <th class="text-center" scope="col">Hoạt động</th>
                </tr>
              </thead>
              <tbody class="table-group-divider ">
                @foreach ($data as $each)
                <tr>
                  <th class="text-center ">{{ $each->Id_ContentPack }}</th>
                  <td class="text-center ">{{ $each->Count_Pack }}</td>
                  <td class="text-center ">
                    {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center">
                      <div class="progress w-50 position-relative" role="progressbar"
                        aria-valuenow="{{ $each->progress }}" aria-valuemin="0" aria-valuemax="100"
                        style="height: 20px">
                        <div class="progress-bar bg-primary-color" style="width: {{ $each->progress }}%">
                        </div>
                        <span class="progress-text fw-bold fs-6 
                          {{ $each->progress > 35 ? 'text-white' : 'text-primary-color'}}">
                          {{ $each->progress }}%
                        </span>
                      </div>
                    </div>
                  </td>
                  <td class="text-center ">
                    <!-- Button trigger modal -->
                    <button type="button"
                      class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail"
                      data-bs-toggle="modal" data-id="{{ $each->Id_ContentPack }}"
                      data-bs-target="#i{{ $each->Id_ContentPack }}">
                      <i class="fa-solid fa-eye"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="i{{ $each->Id_ContentPack }}" data-bs-backdrop="static"
                      data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered ">
                        <div class="modal-content">
                          <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                            <h5 class="modal-title w-100 " id="istaticBackdropLabel">
                              Chi tiết gói hàng
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class='table table-bordered '>
                              <thead>
                                <tr>
                                  <th scope="col" class="align-middle text-center col-md-2">Nguyên liệu</th>
                                  <th class="text-center align-middle" scope="col">Số lượng nguyên liệu</th>
                                  <th class="text-center align-middle" scope="col">Đơn vị</th>
                                  <th class="text-center align-middle" scope="col">Thùng chứa</th>
                                  <th class="text-center align-middle" scope="col">Số lượng thùng chứa</th>
                                  <th class="text-center align-middle" scope="col">Đơn giá</th>
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
          console.log(response);
          $(".body-table").html(response);
        }
      });
    });
  });
</script>
@endpush