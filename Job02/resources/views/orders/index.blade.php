@extends('layouts.master')

@section('title', 'Quản lý đơn hàng')


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header px-0 pt-0 overflow-hidden">
          <h3 class="card-title bg-secondary-subtle p-3 text-primary-color">Quản lý đơn hàng</h3>
          <a href="{{ route('orders.create')}}" class="btn btn-primary-color text-white p-2 my-3 ms-3">
            Thêm đơn hàng
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">Mã đơn hàng</th>
                <th scope="col">Tên khách hàng</th>
                <th class="text-center" scope="col">Kiểu đơn hàng</th>
                <th class="text-center" scope="col">Ngày đặt hàng</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach($data as $each)
              <tr>
                <td class="text-center">{{ $each->Id_Order }}</td>
                <td>{{ $each->customer->Name_Customer}}</td>
                <td class="text-center">{{ $each->type->Name_OrderType }}</td>
                <td class="text-center">{{ $each->order_date}}</td>
                <td>
                  <a href="" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc sản phẩm này
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                          </form>
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
    </div>
  </div>
</div>
@if(session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class=" d-flex justify-content-center align-items-center gap-2">
        @if(session('type') == 'success')
        <i class="fas fa-check-circle text-light fs-5"></i>
        @elseif(session('type') == 'danger' || session('type') == 'warning')
        <i class="fas fa-xmark-circle text-light fs-5"></i>
        @elseif(session('type') == 'info' || session('type') == 'secondary')
        <i class="fas fa-info-circle text-light fs-5"></i>
        @endif
        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@endsection

@push('javascript')
<script type="text/javascript">
  $(document).ready(function () {
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })
</script>
@endpush