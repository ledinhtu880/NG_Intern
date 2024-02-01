@extends('layouts.master')

@section('title', 'Quản lý người dùng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý người dùng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý người dùng</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <a href="{{ route('users.create') }}" class="btn btn-danger rounded-1">
                                <i class="fa-solid fa-plus text-white me-3 fs-6"></i>
                                <span>Thêm người dùng</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            <div>
                                <button type="button" class="btn text-secondary" data-bs-toggle="modal"
                                    data-bs-target="#deleteUser">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa những người dùng đã chọn ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <button type="button" id="btnDelete" class="btn btn-danger">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <form action="" id="formSearch">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm kiếm người dùng">
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table mt-4">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">Chọn</th>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Tên người dùng</th>
                                <th scope="col" class="py-3">Tài khoản</th>
                                <th scope="col" class="py-3 text-center">Vai trò</th>
                                <th scope="col" class="py-3 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center" data-id="Id_User" data-value="{{ $user->Id_User }}">
                                        <input type="checkbox" class="form-check-input" data-id="{{ $user->Id_User }}">
                                    </td>
                                    <td class="text-center">{{ $user->Id_User }}</td>
                                    <td>{{ $user->Name }}</td>
                                    <td>{{ $user->UserName }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm text-secondary btnShow"
                                            data-bs-toggle="modal" data-bs-target="#role-{{ $user->Id_User }}"
                                            data-id="{{ $user->Id_User }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <div class="modal fade" id="role-{{ $user->Id_User }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vai trò của
                                                            người dùng {{ $user->Name }}
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table m-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th scope="col" class="py-3 text-center">#</th>
                                                                    <th scope="col" class="py-3">Tên vai trò</th>
                                                            </thead>
                                                            <tbody id="table-roles">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', compact('user')) }}"
                                            class="btn btn-sm text-secondary btn_edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#i{{ $user->Id_User }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="i{{ $user->Id_User }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa người dùng
                                                        {{ $user->Name }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('users.destroy', $user) }}"
                                                            method="POST">
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
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <nav>
                        @if ($users->lastPage() > 1)
                            {{ $users->links('pagination::bootstrap-4') }}
                        @endif
                    </nav>
                    <a href="{{ route('index') }}" class="btn btn-light">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    @if (session('message') && session('type'))
        <div class=" toast-container rounded position-fixed bottom-0 end-0 p-3">
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="toastMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center justify-content-between">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <i id="icon" class="fas text-light fs-5"></i>
                    <h6 id="toast-msg" class="h6 text-white m-0"></h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            const toastLiveExample = $('#liveToast');
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            toastBootstrap.show();
            let token = $('meta[name="csrf-token"]').attr("content");

            $(document).on("click", ".btnShow", function() {
                let id = $(this).data("id");
                let modalElement = $("#role-" + id); // Lấy modal tương ứng với hàng

                $.ajax({
                    url: "/users/showRoles",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        if (response.length == 0) {
                            modalElement.find('table').html('Người dùng chưa được cấp vai trò');
                        } else {
                            modalElement.find('#table-roles').html('');
                            response.forEach((role) => {
                                modalElement.find('#table-roles').append(`
                <tr>
                  <td class="text-center">${role.Id_Role}</td>
                  <td>${role.Name_Role}</td>
                </tr>
              `);
                            });
                        }
                    },
                });
            });

            $("#btnDelete").on('click', function() {
                const toastElement = $("#toastMessage");
                const toastBs = new bootstrap.Toast(toastElement.get(0));

                function showToast(message, bgColorClass, iconClass) {
                    $(".toast-body").addClass(bgColorClass);
                    $("#icon").addClass(iconClass);
                    $("#toast-msg").html(message);
                    toastBs.show();

                    setTimeout(() => {
                        toastBs.hide();
                        setTimeout(() => {
                            $(".toast-body").removeClass(bgColorClass);
                            $("#icon").removeClass(iconClass);
                            $("#toast-msg").html();
                        }, 1000);
                    }, 5000);
                }

                let modalElement = $("#deleteUser");
                let rowElements = $("#table-data tr");
                let rowDataArray = [];
                let isValid = false;
                rowElements.each(function() {
                    if ($(this).find("input[type=checkbox]").prop("checked") === true) {
                        let rowData = {};
                        rowData.Id_User = $(this)
                            .find('td[data-id="Id_User"]')
                            .data("value");
                        rowDataArray.push(rowData);
                        isValid = true;
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: "/users/destroyUsers",
                        type: "post",
                        data: {
                            rowData: rowDataArray,
                            _token: token,
                        },
                        success: function(response) {
                            rowElements.each(function() {
                                if (
                                    $(this)
                                    .find("input[type=checkbox]")
                                    .prop("checked") === true
                                ) {
                                    $(this).remove();
                                }

                                showToast(
                                    "Xóa người dùng thành công",
                                    "bg-success",
                                    "fa-check-circle"
                                );
                                modalElement.modal('hide');
                            });
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                } else {
                    showToast(
                        "Vui lòng chọn người dùng",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                    modalElement.modal('hide');
                }
            })

            $("#formSearch").on('submit', function(ev) {
                ev.preventDefault();
                let searchValue = $("input[name='search']").val();
                $.ajax({
                    url: "/users/searchUsers",
                    type: "post",
                    data: {
                        searchValue: searchValue,
                        _token: token,
                    },
                    success: function(response) {
                        let table = $("#table-data");
                        table.html('');
                        let html = '';
                        response.forEach((each) => {
                            html = `<tr>
              <td class="text-center" data-id="Id_User" data-value="${each.Id_User}">
                <input type="checkbox" class="form-check-input" data-id="${each.Id_User}">
              </td>
              <td class="text-center">${each.Id_User}</td>
              <td>${each.Name}</td>
              <td>${each.UserName}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm text-secondary btnShow" data-bs-toggle="modal"
                  data-bs-target="#role-${each.Id_User}" data-id="${each.Id_User}">
                  <i class="fa-solid fa-eye"></i>
                </button>

                <div class="modal fade" id="role-${each.Id_User}" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vai trò của người dùng ${each.Name}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table m-0">
                          <thead class="table-light">
                            <tr>
                              <th scope="col" class="py-3 text-center">#</th>
                              <th scope="col" class="py-3">Tên vai trò</th>
                          </thead>
                          <tbody id="table-roles">
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td class="text-center">
                <a href="/users/${each.Id_User}/edit" class="btn btn-sm text-secondary btn_edit">
                  <i class="fa-solid fa-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal"
                  data-bs-target="#i${each.Id_User}">
                  <i class="fa-solid fa-trash"></i>
                </button>
                <div class="modal fade" id="i${each.Id_User}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        ${each.Name}?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <form action="/users/${each.Id_User}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>`
                            table.append(html);
                        })
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            })
        })
    </script>
@endpush
