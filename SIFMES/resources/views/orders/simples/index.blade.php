@extends('layouts.master')

@section('title', 'Quản lý đơn thùng hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý đơn thùng hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý đơn thùng hàng</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('orders.simples.create') }}" class="btn btn-danger rounded-1">
                            <i class="fa-solid fa-plus text-white me-3 fs-6"></i>
                            <span>Thêm đơn thùng hàng</span>
                        </a>
                    </div>
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Tên khách hàng</th>
                                <th scope="col" class="py-3">Kiểu khách hàng</th>
                                <th scope="col" class="py-3">Ngày đặt hàng</th>
                                <th scope="col" class="py-3">Ngày giao hàng</th>
                                <th scope="col" class="py-3 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $each)
                                <tr>
                                    <th scope="row" class="text-center text-body-secondary">{{ $each->Id_Order }}</th>
                                    <td>{{ $each->customer->Name_Customer }}</td>
                                    <td>
                                        <span class="badge text-bg-primary fw-normal fs-6">{{ $each->Name }}</span>
                                    </td>
                                    <td>{{ $each->order_date }}</td>
                                    <td>{{ $each->delivery_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.simples.show', $each) }}"
                                            class="btn btn-sm text-secondary">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.simples.edit', $each) }}"
                                            class="btn btn-sm text-secondary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#deleteOrder-{{ $each->Id_Order }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="deleteOrder-{{ $each->Id_Order }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title fw-bold text-secondary"
                                                            id="exampleModalLabel">Xác nhận</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn về việc thùng hàng này
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <form method="POST"
                                                            action="{{ route('orders.simples.destroy', $each) }}">
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
                        @if ($data->lastPage() > 1)
                            {{ $data->links('pagination::bootstrap-4') }}
                        @endif
                    </nav>
                    <a href="{{ route('index') }}" class="btn btn-light">Quay lại</a>
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
            const toastLiveExample = $('#liveToast');
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            toastBootstrap.show();
        })
    </script>
@endpush
