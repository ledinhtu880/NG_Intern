@extends('layouts.master')

@section('title', 'Xem chi tiết nguyên liệu thô')

@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
      <div class="card border-0 shadow overflow-hidden" style="width: 650px">
        <div class="row g-0">
          <div class="card-body d-flex flex-column justify-content-between h-100">
            <div class="row">
              <h4 class="h4 card-title border-bottom mb-3">Thông tin nguyên liệu thô</h4>
              <div class="col-md-6 mb-4">
                <h5 class="h5 fw-medium mb-1">Tên nguyên liệu</h5>
                <h6 class="h6 text-muted fw-normal m-0">{{ $material->name }}</h6>
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
                <h6 class="h6 text-muted fw-normal m-0">{{ $material->count }}</h6>
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
@endsection