@extends('layouts.master')

@section('title', ' Quản lý vai trò')

@push('css')
    <style>
        .d-inline-flex+.list-group:hover {
            cursor: pointer !important;
        }
    </style>
@endpush
@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý vai trò</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Quản lý vai trò
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">
                        <i class="fa-solid fa-person-circle-check me-2"></i>
                        <span>Đăng ký vai trò</span>
                    </h5>
                    <div class="row">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="users">Người dùng</label>
                            <select class="form-select" id="users">
                                @foreach ($users as $user)
                                    <option value="{{ $user->Id_User }}">{{ $user->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $count = 1;
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            @foreach ($type_role as $key => $item)
                                <div class="role-item">
                                    <div class="p-3 px-0">
                                        <span data-bs-toggle="collapse" style="cursor: pointer !important;"
                                            data-bs-target="#collapseRole{{ $key }}">
                                            {{ $item }}
                                        </span>
                                    </div>
                                    <ul class="list-group collapse cursor-pointer" id="collapseRole{{ $key }}"
                                        data-bs-parent="#accordion">
                                        @foreach ($roles as $role)
                                            @if ($role->FK_Id_RoleParent == $key)
                                                <li class="list-group-item">
                                                    <input class="form-check-input me-1 checkbox" type="checkbox"
                                                        value="" id="role{{ $role->Id_Role }}">
                                                    <label class="form-check-label stretched-link"
                                                        for="role{{ $role->Id_Role }}">{{ $role->Name_Role }}</label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-outline float-end" data-bs-toggle="modal" data-bs-target="#modalstart"
                            id="btnSave">Lưu
                            lại</button>
                        <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn chắc chắn muốn đăng ký vai trò cho người dùng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary btn-primary" data-bs-dismiss="modal"
                                            id="confirm">Xác nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

@endsection
@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const toastLiveExample = $('#liveToast');
            if (toastLiveExample.length > 0) {
                const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
                toastBootstrap.show();
            }

            var role_id = [];
            var checkbox_lst = $('.checkbox');
            $(document).on("change", ".checkbox", function() {
                let checkedValue = $(this).attr('id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    role_id.push(checkedValue);
                } else {
                    role_id = role_id.filter(function(element) {
                        return element !== checkedValue;
                    });
                }
            });


            $('#users').change(function() {
                role_id = [];
                let user_id = $(this).val();
                checkbox_lst.each(function() {
                    $(this).prop('checked', false);
                });
                $.ajax({
                    url: '/roles/showRoleByUser/',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: user_id,
                    },
                    success: function(response) {
                        let list_role = response;
                        list_role.forEach(element => {
                            if (element['FK_Id_User'] == user_id) {
                                let role_chk = "role" + element['FK_Id_Role'];
                                $('#' + role_chk).prop('checked', true);
                                role_id.push(element['FK_Id_Role']);
                            }
                        });
                    }
                });

            });

            $('#users').change();

            $('#confirm').on('click', function() {
                let user_id = $('#users').val();
                $.ajax({
                    url: '/roles/store/',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        role_id: role_id,
                        user_id: user_id,
                    },
                    success: function(response) {
                        window.location.href = response.url;
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
