@extends('layouts.master')

@section('title', 'Xem chi tiết đơn gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('packs.index') }}">Quản lý đơn gói hàng</a>
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
              <div class="col-md-4">
                <div class="row align-items-center ">
                  <div class="col-md-12 mb-3">
                    <div class="d-flex algin-item-center">
                      <span class="bg-secondary-subtle px-2 py-1 rounded rounded-end-0 text-nowrap ">
                        Khách hàng
                      </span>
                      <span class="px-2 py-1 border-secondary-subtle border rounded-end border-start-0 w-100">{{
                        $order->customer->Name_Customer }}</span>
                    </div>
                  </div>
                  <div class="col-md-12">
                    {{-- DateOrder --}}
                    <div class="d-flex">
                      <span class="bg-secondary-subtle px-2 py-1 rounded rounded-end-0 text-nowrap ">Ngày đặt
                        hàng</span>
                      <span class="px-2 py-1 border-secondary-subtle border rounded-end border-start-0 w-100">
                        {{ \Carbon\Carbon::parse($order->Date_Order)->format('d/m/Y') }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    {{-- DateDilivery --}}
                    <div class="d-flex">
                      <span class="bg-secondary-subtle px-2 py-1 rounded rounded-end-0 text-nowrap ">Ngày giao
                        hàng</span>
                      <span class="px-2 py-1 border-secondary-subtle border rounded-end border-start-0 w-100">
                        {{ \Carbon\Carbon::parse($order->Date_Dilivery)->format('d/m/Y') }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    {{-- DateReception --}}
                    <div class="d-flex">
                      <span class="bg-secondary-subtle px-2 py-1 rounded rounded-end-0 text-nowrap ">Ngày nhận
                        hàng</span>
                      <span class="px-2 py-1 border-secondary-subtle border rounded-end border-start-0 w-100">
                        {{ \Carbon\Carbon::parse($order->Date_Reception)->format('d/m/Y') }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 d-flex">
                {{-- Note --}}
                <span class="bg-secondary-subtle px-2 py-1 rounded rounded-end-0 text-center">Ghi chú</span>
                <span class="px-2 py-1 border-secondary-subtle border rounded-end border-start-0 w-100">
                  {{ $order->Note === '' ? $order->Note : 'Không có ghi chú' }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin gói hàng</h4>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Mã gói hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center" scope="col">Hoạt động</th>
                </tr>
              </thead>
              <tbody class="table-group-divider ">
                @foreach ($contentPacks as $contentPack)
                <tr>
                  <th class="text-center ">{{ $contentPack->Id_PackContent }}</th>
                  <td class="text-center ">{{ $contentPack->Count_Pack }}</td>
                  <td class="text-center ">{{ $contentPack->Price_Pack }}</td>
                  <td class="text-center ">
                    <!-- Button trigger modal -->
                    <button type="button"
                      class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail"
                      data-bs-toggle="modal" data-id="{{ $contentPack->Id_PackContent }}"
                      data-bs-target="#i{{ $contentPack->Id_PackContent }}">
                      <i class="fa-solid fa-eye"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="i{{ $contentPack->Id_PackContent }}" data-bs-backdrop="static"
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
                                  <th class="text-center align-middle " scope="col">Số lượng nguyên liệu</th>
                                  <th class="text-center align-middle" scope="col">Đơn vị</th>
                                  <th class="text-center align-middle" scope="col">Thùng chứa</th>
                                  <th class="text-center align-middle " scope="col">Số lượng thùng chứa</th>
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
        </div>
        <div class="d-flex align-items-center justify-content-end mt-3">
          <a href="{{ route('packs.index') }}" class="btn btn-lg btn-primary-color px-4" id="btn_save">Quay lại</a>
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
      let id_PackContent = $(this).data('id');

      $.ajax({
        url: '/packs/showDetailsPack',
        type: 'POST',
        data: {
          _token: $("meta[name='csrf-token']").attr('content'),
          id_PackContent: id_PackContent
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