@extends('layouts.master')

@section('title', 'Quản lý khách hàng')


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý đơn khách hàng</li>
        </ol>
      </nav>
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý khách hàng</h4>
          <a href="{{ route('customers.create')}}" class="btn btn-primary-color text-white py-2 px-5 m-3">
            Thêm khách hàng
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">#</th>
                <th scope="col">Tên khách hàng</th>
                <th class="text-center" scope="col">Số điện thoại</th>
                <th class="text-center" scope="col">Kiểu khách hàng</th>
                <th class="text-center" scope="col">Phương thức vận chuyển</th>
                <th class="text-center" scope="col">Địa chỉ</th>
                <th class="text-center" scope="col"></th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($datas as $data)
              <tr>
                <th class="text-center" scope="row">{{ $data->Id_Customer }}</th>
                <td>{{ $data->Name_Customer }}</td>
                <td class="text-center">{{ $data->Phone }}</td>
                <td class="text-center">{{ $data->customerType->Name }}</td>
                <td class="text-center">{{ $data->types->Name_ModeTransport }}</td>
                <td class="text-center">{{ $data->Address }}</td>
                <td class="text-center">
                  <a href="{{ route('customers.show', ['customer' => $data]) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('customers.edit', ['customer' => $data]) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#i{{ $data->Id_Customer }}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="i{{ $data->Id_Customer }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn muốn xóa người dùng
                          {{ $data->Name_Customer }}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form action="{{ route('customers.destroy', ['customer' => $data]) }}" method="POST">
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
          {{-- paginate --}}
          <nav class="d-flex justify-content-end me-2">
            {{ $datas->links('pagination::bootstrap-4') }}
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@if (session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class=" d-flex justify-content-center align-items-center gap-2">
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