@extends('layouts.master')

@section('title', 'Quản lý dây chuyền sản xuất')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý dây chuyền sản xuất</li>
        </ol>
      </nav>
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý dây chuyền sản xuất</h4>
          <a href="{{ route('productStationLines.create')}}" class="btn btn-primary-color text-white py-2 px-5 m-3">
            Thêm dây chuyền sản xuất
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">#</th>
                <th scope="col">Tên dây chuyền</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Loại</th>
                <th class="text-center" scope="col"></th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($data as $each)
              <tr>
                <th class="text-center" scope="col">{{ $each->Id_ProdStationLine }}</th>
                <td>{{ $each->Name_ProdStationLine }}</td>
                <td>{{ $each->Description }}</td>
                <td scope="col">{{ $each->orderType->Name_OrderType }}</td>
                <td class="text-center">
                  <a href="{{ route('productStationLines.show', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary"><i
                      class="fa-solid fa-eye"></i></a>
                  <a href="{{ route('productStationLines.edit', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary"><i
                      class="fa-solid fa-pen-to-square"></i></a>
                  <a href="" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#i{{ $each->Id_ProdStationLine }}"><i
                      class="fa-solid fa-trash"></i></a>
                  <div class="modal fade" id="i{{ $each->Id_ProdStationLine }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc xóa dây chuyền xử lý sản xuất này?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form action="{{ route('productStationLines.destroy', $each) }}" method="POST">
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