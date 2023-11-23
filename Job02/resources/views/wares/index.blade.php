@extends('layouts.master')

@section('title', 'Quản lý kho thùng')

@push('css')
@endpush

@section('content')
<div class="container-fluid border border-dark-subtle w-25 border-0">
    <div class="card">
        <div class="card-header d-flex align-items-center" style="background-color: #2b4c72">
            <h6 style="color: white">Kho chứa</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column align-items-center">
                <a href="{{ route('wares.create') }}" class="btn btn-primary-color my-1 w-50">Khởi tạo kho</a>
                <a href="{{ route('wares.show') }}" class="btn btn-primary-color my-1 w-50">Chi tiết kho</a>
            </div>
        </div>
    </div>
</div>
@endsection