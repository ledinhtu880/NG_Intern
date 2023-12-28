@extends('layouts.master')

@section('title', 'Quản lý người dùng')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý nguời dùng</li>
        </ol>
      </nav>
      <div class="card mt-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Quản lý người dùng</h4>
          <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary-color text-white py-2 px-5 m-3">
              Thêm người dùng
            </a>
          </div>
          <div class="col-md-5 ps-3 pb-3 d-flex align-items-center">
            <div class="me-3">
              <button type="button" class="btn btn-xl btn-outline-light text-primary-color border-secondary"
                data-bs-toggle="modal" data-bs-target="#deleteUser">
                <i class="fa-solid fa-trash"></i>
              </button>
              <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận
                      </h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Bạn có chắc chắn muốn xóa những người dùng đã chọn ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                      <button type="button" id='btn_delete' class="btn btn-danger">Xóa</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <input type="text" name="search" class="form-control" placeholder="Tìm kiếm người dùng">
            </div>
          </div>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col"></th>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Tên người dùng</th>
                <th class="text-center" scope="col">Tài khoản</th>
                <th class="text-center" scope="col">Vai trò</th>
                <th class="text-center" scope="col">Hoạt động</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($users as $user)
              <tr>
                <td class="text-center">
                  <input type="checkbox" class="form-check-input is-selected" data-id='{{ $user->Id_User }}'>
                </td>
                <td class="text-center">{{ $user->Id_User }}</td>
                <td class="text-center">{{ $user->Name }}</td>
                <td class="text-center">{{ $user->UserName }}</td>
                <td class="text-center">Trống</td>
                <td class="text-center">
                  <a href="{{ route('users.edit', compact('user')) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary btn_edit">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#i{{ $user->Id_User }}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="i{{ $user->Id_User }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn muốn xóa người dùng
                          {{ $user->Name }}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form action="{{ route('users.destroy', $user) }}" method="POST">
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
            {{ $users->links('pagination::bootstrap-4') }}
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
    // // tìm kiếm người dùng
    // $('input[name="search"]').keyup(function() {
    //   var query = $(this).val();
    //   $.ajax({
    //     url: '/searchUser',
    //     method: "POST",
    //     data: {
    //       query: query,
    //       _token: $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function(data) {
    //       $('#table-data').html(data);
    //     }
    //   });
    // });

    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })
</script>
@endpush