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
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý vai trò</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý vai trò</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">
                        <i class="fa-solid fa-person-circle-check me-2"></i>
                        Đăng ký vai trò
                        </h5>
                </div>
                <div class="card-body">
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
                                <div class="border border-dark border-start-0 border-end-0">
                                    <p class="d-inline-flex">
                                    <div data-bs-toggle="collapse" style="cursor: pointer !important;"
                                        data-bs-target="#collapseRole{{ $key }}">
                                        {{ $item }}</div>
                                    </p>
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
                                        <div class="mb-3"></div>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalstart"
                        id="btnSave">Lưu
                        lại</button>
                    <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn chắc chắn muốn đăng ký vai trò cho người dùng này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
