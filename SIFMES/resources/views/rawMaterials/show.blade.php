@extends('layouts.master')

@section('title', 'Xem chi tiết nguyên liệu thô')

@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50 d-flex flex-column">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item">
              <a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
              <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết nguyên liệu thô</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin nguyên liệu thô</h4>
          </div>
          <div class="row g-0">
            <div class="card-body d-flex flex-column justify-content-between h-100">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <h5 class="h5 fw-medium mb-1">Tên nguyên liệu</h5>
                  <h6 class="h6 text-muted fw-normal m-0">{{ $material->Name_RawMaterial }}</h6>
                </div>
                <div class="col-md-6 mb-4">
                  <h5 class="h5 fw-medium mb-1">Đơn vị</h5>
                  <h6 class="h6 text-muted fw-normal m-0">{{ $material->Unit }}</h6>
                </div>
                <div class="col-md-6 mb-4">
                  <h5 class="h5 fw-medium mb-1">Loại nguyên liệu thô</h5>
                  <h6 class="h6 text-muted fw-normal m-0">{{ $material->types->Name_RawMaterialType }}</h6>
                </div>
                <div class="col-md-6 mb-4">
                  <h5 class="h5 fw-medium mb-1">Số lượng</h5>
                  <h6 class="h6 text-muted fw-normal m-0">{{ $material->Count }}</h6>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('rawMaterials.index') }}" class="btn btn-warning">Quay lại</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection