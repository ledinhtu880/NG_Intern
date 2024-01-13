@extends('layouts.master')

@section('title', 'Quản lý kho thùng')

@push('css')
@endpush

@section('content')
<div class="row g-0 p-3">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý kho chứa</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý kho chứa</li>
        </ol>
    </div>
</div>
<div class="row g-0 p-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-white">
                <h4 class="card-title m-0 fw-bold text-body-secondary">Kho chứa</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('wares.create') }}" class="btn btn-primary">Khởi tạo
                    kho</a>
                <a href="{{ route('wares.show') }}" class="btn btn-primary">Chi tiết kho</a>
            </div>
            <div class="card-footer d-flex gap-2 align-items-end justify-content-end">
                <a href="{{ route('index') }}" class="btn btn-light">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection