@extends('layouts.master')

@section('title', 'Quản lý trạm')


@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý trạm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Quản lý trạm
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <a href="{{ route('stations.create') }}" class="btn btn-main">
                        <i class="fa-solid fa-plus text-white me-1 fs-6"></i>
                        <span>Thêm trạm</span>
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Tên trạm</th>
                                <th scope="col" class="py-2">Địa chỉ IP</th>
                                <th scope="col" class="py-2 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($stations as $station)
                                <tr class="align-middle">
                                    <th class="text-center text-body-secondary" scope="row">{{ $station->Id_Station }}
                                    </th>
                                    <td>{{ $station->Name_Station }}</td>
                                    <td>{{ $station->Ip_Address }}</td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('stations.edit', $station) }}" class="btn btn-sm btn-outline">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-outline" data-bs-toggle="modal"
                                            data-bs-target="#i{{ $station->Id_Station }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <div class="modal fade" id="i{{ $station->Id_Station }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="m-0">Bạn chắc chắn muốn xóa trạm này?</p>
                                                        <p class="m-0">
                                                            Việc này sẽ xóa trạm vĩnh viễn. <br>
                                                            Hãy chắc chắn trước khi tiếp tục.
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('stations.destroy', $station) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Xác nhận</button>
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
                @if ($stations->lastPage() > 1)
                    <div class="card-footer pt-0 border-0 bg-transparent">
                        <nav>
                            {{ $stations->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                @endif
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('javascript')
    <script type="text/javascript">
        const toastLiveExample = $("#liveToast");
        const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
        toastBootstrap.show();
    </script>
@endpush
