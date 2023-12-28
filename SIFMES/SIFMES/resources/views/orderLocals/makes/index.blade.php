@extends('layouts.master')

@section('title', 'Quản lý đơn sản xuất')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý đơn sản xuất</li>
        </ol>
      </nav>
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý đơn sản xuất</h4>
          <a href="{{ route('orderLocals.makes.create')}}" class="btn btn-primary-color text-white py-2 px-5 m-3">
            Thêm đơn sản xuất
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr class="text-center">
                <th scope="col">Mã đơn</th>
                <th scope="col">Kiểu hàng</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Ngày giao hàng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Ngày hoàn thành</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider text-center">
              @foreach($data as $each)
              <tr>
                <td>{{ $each->Id_OrderLocal }}</td>
                <td>{{ $each->type }}</td>
                <td>{{ $each->Count }} gói</td>
                <td>{{ $each->delivery_date }}</td>
                <td>{{ $each->status }}</td>
                <td>{{ $each->finally_date }}</td>
                <td>
                  <a href="{{ route('orderLocals.makes.show', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('orderLocals.makes.edit', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#deleteOrder-{{$each->Id_OrderLocal}}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="deleteOrder-{{$each->Id_OrderLocal}}" tabindex="-1"
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
                          <form method="POST" action="{{ route('orderLocals.makes.destroy', $each) }}">
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
            {{ $data->links('pagination::bootstrap-5')}}
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@if(session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class="d-flex justify-content-center align-items-center gap-2">
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