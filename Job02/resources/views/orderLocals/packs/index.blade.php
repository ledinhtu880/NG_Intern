@extends('layouts.master')

@section('title', 'Quản lý đơn đóng gói')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý đơn đóng gói</h4>
          <a href="{{ route('orderLocals.packs.create') }}" class="btn btn-primary-color text-white py-2 px-5 m-3">
            Thêm đơn đóng gói
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">Mã đơn</th>
                <th class="text-center" scope="col">Kiểu gói</th>
                <th class="text-center" scope="col">Số lượng</th>
                <th class="text-center" scope="col">Ngày giao hàng</th>
                <th class="text-center" scope="col">Trạng thái</th>
                <th class="text-center" scope="col">Ngày hoàn thành</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($data as $each)
              <tr>
                <td class="text-center">{{ $each->Id_OrderLocal }}</td>
                <td class="text-center">{{ $each->getTypeAttribute() }}</td>
                <td class="text-center">{{ $each->Count }} gói</td>
                <td class="text-center">{{ $each->getDeliveryDateAttribute() }}</td>
                <td class="text-center">{{ $each->getStatusAttribute() }}</td>
                <td class="text-center">{{ $each->getFinallyDateAttribute() }}</td>
                <td>
                  <a href="{{ route('orderLocals.packs.showDetails', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('orderLocals.packs.showEdit', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#deleteOrder-{{ $each->Id_OrderLocal }}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="deleteOrder-{{ $each->Id_OrderLocal }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <form method="POST"
                            action="{{ route('orderLocals.packs.deleteOrderLocal', $each->Id_OrderLocal) }}">
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
        @if ($data->lastPage() > 1)
        <div class="card-footer">
          <div class="paginate">
            {{ $data->links('pagination::bootstrap-5') }}
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@if (session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class="d-flex justify-content-center align-items-center gap-2">
        @if (session('type') == 'success')
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