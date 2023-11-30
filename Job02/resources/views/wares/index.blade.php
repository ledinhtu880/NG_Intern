@extends('layouts.master')

@section('title', 'Quản lý kho thùng')

@push('css')
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="w-25 d-flex flex-column">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none" href="{{ route('index') }}">
                                Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quản lý đơn kho chứa</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header p-0 overflow-hidden">
                        <h4 class="card-title m-0 bg-primary-color p-3">Kho chứa</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="{{ route('wares.create') }}" class="btn btn-primary-color my-1 w-50">Khởi tạo
                                kho</a>
                            <a href="{{ route('wares.show') }}" class="btn btn-primary-color my-1 w-50">Chi tiết kho</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection