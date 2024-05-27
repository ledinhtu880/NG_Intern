@extends('layouts.master')

@section('title', 'Quản lý đào tạo')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h3 class="h3 fw-medium">Quản lý đào tạo</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}" class="text-decoration-none fw-medium">Trang chủ</a>
                </li>
                <li class="breadcrumb-item fw-medium active" aria-current="page">Quản lý đào tạo</li>
            </ol>
        </nav>
    </div>
    <div class="row g-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('eduProgram.create') }}" class="btn btn-primary mb-3">
                        <i class="fa-solid fa-plus text-white me-1 fs-6"></i>
                        Thêm môn học
                    </a>
                    <div class="table-responsive">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-2 text-center">Mã môn học</th>
                                    <th scope="col" class="py-2">Tên môn học</th>
                                    <th scope="col" class="py-2 text-center">Ký hiệu</th>
                                    <th scope="col" class="py-2 text-center">Lý thuyết</th>
                                    <th scope="col" class="py-2 text-center">Bài tập</th>
                                    <th scope="col" class="py-2 text-center">Thực hành</th>
                                    <th scope="col" class="py-2 text-center">Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $each)
                                    <tr class="align-middle">
                                        <th scope="row" class="text-center text-body-secondary">
                                            {{ $each->{"Mã môn học"} }}
                                        </th>
                                        <td>{{ $each->{"Tên môn học"} }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge text-bg-secondary fw-medium fs-6">{{ $each->{"Ký hiệu"} }}</span>
                                        </td>
                                        <td class="text-center">{{ $each->{"Lý thuyết"} }}</td>
                                        <td class="text-center">{{ $each->{"Bài tập"} }}</td>
                                        <td class="text-center">{{ $each->{"Thực hành"} }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('eduProgram.edit', $each->{"Mã môn học"}) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="modal" data-bs-target="#i{{ $each->{"Mã môn học"} }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="i{{ $each->{"Mã môn học"} }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-0">Bạn chắc chắn muốn xóa môn học này?</p>
                                                            <p class="m-0">
                                                                Việc này sẽ xóa môn học vĩnh viễn. <br>
                                                                Hãy chắc chắn trước khi tiếp tục.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Hủy</button>
                                                            <form
                                                                action="{{ route('eduProgram.destroy', $each->{"Mã môn học"}) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    Xác nhận
                                                                </button>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            let token = $('meta[name="csrf-token"]').attr("content");
            const toastLiveExample = $('#liveToast');
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            toastBootstrap.show();
        })
    </script>
@endpush
