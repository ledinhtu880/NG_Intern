@extends('layouts.master')

@section('title', 'Chi tiết đơn thùng hàng')
@push('css')
    <style>
        .progress-text {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row pb-5">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="w-100">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
                            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang
                                    chủ</a></li>
                            <li class="breadcrumb-item active">
                                <a class="text-decoration-none" href="{{ route('tracking.orderlocals.index') }}">Theo dõi
                                    đơn hàng nội bộ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết đơn thùng hàng</li>
                        </ol>
                    </nav>
                    <div class="card mt-3">
                        <div class="card-header p-0 overflow-hidden">
                            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin thùng hàng</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered m-0">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" scope="col">Mã thùng hàng</th>
                                        <th class="text-center align-middle" scope="col">Nguyên liệu</th>
                                        <th class="text-center align-middle" scope="col">Đơn vị</th>
                                        <th class="text-center align-middle" scope="col">Thùng chứa</th>
                                        <th class="text-center align-middle" scope="col">Thành tiền</th>
                                        <th class="text-center align-middle" scope="col">Trạng thái dây chuyền</th>
                                        <th class="text-center align-middle" scope="col">Hoạt động</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($data as $each)
                                        <tr>
                                            <td class="text-center align-middle">{{ $each->Id_ContentSimple }}</td>
                                            <td class="text-center align-middle">{{ $each->Name_RawMaterial }}
                                            </td>
                                            <td class="text-center align-middle">{{ $each->Unit }}</td>
                                            <td class="text-center align-middle">{{ $each->Name_ContainerType }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') . ' VNĐ' }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <div class="progress w-50 position-relative" role="progressbar"
                                                        aria-valuenow="{{ $station_currents[$count] ?? 0 }}"
                                                        aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                                        <div class="progress-bar bg-primary-color"
                                                            style="width: {{ $station_currents[$count] ?? 0 }}%">
                                                        </div>
                                                        <span
                                                            class="progress-text fw-bold fs-6
                              @if (isset($station_currents[$count]) && $station_currents[$count] >= 45) text-white
                              @else text-primary-color @endif
                            ">
                                                            {{ $station_currents[$count] ?? 0 }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('tracking.orderlocals.showDetailsSimple', $each->Id_ContentSimple)}}" target="_blank" class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail"><i class="fa-solid fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-end mt-3">
                            <a href="{{ route('tracking.orderlocals.index') }}"
                                class="btn btn-lg btn-primary-color px-4">
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection