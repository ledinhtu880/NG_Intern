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
<div class="row g-0 p-3">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="h4 m-0 fw-bold text-body-secondary">Theo dõi đơn hàng nội bộ</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('tracking.orderlocals.index') }}">Theo
                    dõi đơn hàng nội bộ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thông tin thùng hàng</li>
        </ol>
    </div>
</div>
<div class="row g-0 p-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-white">
                <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3 text-center">#</th>
                            <th scope="col" class="py-3">Nguyên liệu</th>
                            <th scope="col" class="py-3">Đơn vị</th>
                            <th scope="col" class="py-3">Thùng chứa</th>
                            <th scope="col" class="py-3 text-center">Thành tiền</th>
                            <th scope="col" class="py-3 text-center">Trạng thái dây chuyền</th>
                            <th scope="col" class="py-3"></th>
                        </tr>
                    </thead>
                    <tbody id="table-data">
                        @php
                        $count = 0;
                        @endphp
                        @foreach ($data as $each)
                        <tr>
                            <td class="text-center">{{ $each->Id_ContentSimple }}</td>
                            <td>{{ $each->Name_RawMaterial }}
                            </td>
                            <td>{{ $each->Unit }}</td>
                            <td>{{ $each->Name_ContainerType }}
                            </td>
                            <td class="text-center">
                                {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.') .
                                ' VNĐ' }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <div class="progress w-50 position-relative" role="progressbar"
                                        aria-valuenow="{{ $station_currents[$count] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100" style="height: 20px">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $station_currents[$count] ?? 0 }}%">
                                        </div>
                                        <span class="progress-text fw-bold fs-6
                      @if (isset($station_currents[$count]) && $station_currents[$count] >= 45) text-white
                      @else text-primary @endif
                    ">
                                            {{ $station_currents[$count] ?? 0 }}%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{route('tracking.orderlocals.showDetailsSimple', $each->Id_ContentSimple)}}"
                                    target="_blank" class="btn btn-sm text-secondary btn-detail"><i
                                        class="fa-solid fa-eye"></i></a>
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
                <a href="{{ route('tracking.orderlocals.index') }}" class="btn btn-primary">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>
@endsection