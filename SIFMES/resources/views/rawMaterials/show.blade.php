@extends('layouts.master')

@section('title', 'Xem chi tiết nguyên liệu thô')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin nguyên liệu thô</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('rawMaterials.index') }}">Quản lý nguyên liệu thô</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex flex-column justify-content-between h-100">
        <div class="row">
          <div class="col-md-3 mb-4">
            <h5 class="h5 mb-1" style="font-weight: 600;">Tên nguyên liệu</h5>
            <h6 class="h6 text-muted fw-normal m-0">{{ $material->Name_RawMaterial }}</h6>
          </div>
          <div class="col-md-3 mb-4">
            <h5 class="h5 mb-1" style="font-weight: 600;">Đơn vị</h5>
            <h6 class="h6 text-muted fw-normal m-0">{{ $material->Unit }}</h6>
          </div>
          <div class="col-md-3 mb-4">
            <h5 class="h5 mb-1" style="font-weight: 600;">Loại nguyên liệu thô</h5>
            <h6 class="h6 text-muted fw-normal m-0">{{ $material->types->Name_RawMaterialType }}</h6>
          </div>
          <div class="col-md-3 mb-4">
            <h5 class="h5 mb-1" style="font-weight: 600;">Số lượng</h5>
            <h6 class="h6 text-muted fw-normal m-0">{{ $material->Count }}</h6>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end align-items-center">
        <div class="d-flex justify-content-end align-items-center gap-2">
          <a href="{{ route('rawMaterials.index') }}" class="btn btn-primary">Quay lại</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection