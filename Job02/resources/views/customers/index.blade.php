@extends('layouts.master')

@section('title', 'Quản lý khách hàng')


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý khách hàng</h4>
          <a href="{{ route('customers.create')}}" class="btn btn-primary-color text-white p-2 my-3 ms-3">
            Thêm khách hàng
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">#</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Email</th>
                <th class="text-center" scope="col">Số điện thoại</th>
                <th class="text-center" scope="col">Hành động</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($data as $each)
              <tr>
                <th class="text-center" scope="row">{{ $each->Id_Customer }}</th>
                <td class="">{{ $each->Name_Customer }}</td>
                <td>{{ $each->Email }}</td>
                <td class="text-center">{{ $each->Phone }}</td>
                <td class="text-center">
                  <a href="{{ route('customers.show', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('customers.edit', $each) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#i{{ $each->Id_Customer }}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="i{{ $each->Id_Customer }}" tabindex="-1"
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
                          {{ $each->Name_Customer }}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form action="{{ route('customers.destroy', $each) }}" method="POST">
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
<script src="{{ asset('js/app.js') }}"></script>
@endpush