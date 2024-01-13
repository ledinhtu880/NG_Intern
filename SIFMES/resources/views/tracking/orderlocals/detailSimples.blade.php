@extends('layouts.master')

@section('title', 'Thông tin chi tiết thùng hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Thông tin chi tiết thùng hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('tracking.orderlocals.index') }}">Theo
          dõi đơn hàng nội bộ</a>
      </li>
      <li class="breadcrumb-item"><a class="text-decoration-none" href="#">Xem chi tiết</a>
      <li class=" breadcrumb-item active fw-medium" aria-current="page">
        Thông tin thùng hàng
      </li>
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
        <div class="row">
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle">Mã thùng hàng</label>
                  <input type="text" class="form-control" disabled id="Id_ContentSimple" name="Id_ContentSimple"
                    value="{{ $simple->Id_ContentSimple }}">
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle">Tên thùng chứa</label>
                  <input type="text" class="form-control" disabled id="Name_ContainerType" name="Name_ContainerType"
                    value="{{ $simple->type->Name_ContainerType }}">
                </div>
                <span class="form-message text-danger"></span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle" style="width: 175px">Tên nguyên vật
                    liệu</label>
                  <input type="text" class="form-control" disabled id="Name_RawMaterial" name="Name_RawMaterial"
                    value="{{ $simple->material->Name_RawMaterial }}">
                </div>
                <span class="form-message text-danger"></span>
              </div>
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle" style="width: 175px">Số lượng thùng
                    chứa</label>
                  <input type="text" class="form-control" disabled id="Count_Container" name="Count_Container"
                    value="{{ $simple->Count_Container }}">
                </div>
                <span class="form-message text-danger"></span>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle" style="width: 200px;">Số lượng nguyên vật
                    liệu</label>
                  <input type="text" class="form-control" disabled id="Count_RawMaterial" name="Count_RawMaterial"
                    value="{{ $simple->Count_RawMaterial }}">
                </div>
                <span class="form-message text-danger"></span>
              </div>
              <div class="col-md-12 mb-3">
                <div class="input-group">
                  <label class="input-group-text bg-secondary-subtle" style="width: 200px;">Đơn giá thùng chứa</label>
                  <input type="text" class="form-control" disabled id="Price_Container" name="Price_Container"
                    value="{{ number_format($simple->Price_Container, 0, ',', '.') . ' VNĐ' }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="input-group">
                <label class="input-group-text bg-secondary-subtle">Tên khách hàng</label>
                <input type="text" class="form-control" disabled id="Name_Customer" name="Name_Customer"
                  value="{{ $simple->order->customer->Name_Customer }}">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="input-group">
                <label class="input-group-text bg-secondary-subtle">Mã đơn hàng</label>
                <input type="text" class="form-control" disabled id="Id_Order" name="Id_Order"
                  value="{{ $simple->order->Id_Order }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="row my-4">
      <div class="col-md-4 d-flex align-items-center justify-content-center">
        <img src="" alt="Hello" class="w-50 h-50 d-none" id="img-js">
      </div>
      <div class="col-md-8">
        <div class="card border-0 shadow-sm">
          <div class="card-header border-0 bg-white">
            <h5 class="card-title m-0 fw-bold text-body-secondary">Theo dõi thông tin</h5>
          </div>
          @if($simple->progress == 'Thùng hàng chưa được khởi động')
          <h2 class="text-center my-3">Thùng hàng chưa được khởi động</h2>
          @else
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="row gap-2">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" style="width: 215px">
                      Trạng thái hiện tại
                    </label>
                    <input type="text" class="form-control" disabled value="{{ $simple->status }}">
                  </div>
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" style="width: 215px">
                      Tổng thời gian lưu tại trạm
                    </label>
                    <input type="text" class="form-control" disabled value="{{ $simple->elapsedTime }}">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="wrapped d-flex flex-column align-items-center gap-2">
                    <label class="nv-label fw-bold">Trạng thái sản xuất</label>
                    <div class="d-flex justify-content-center w-100">
                      <div class="progress w-50 position-relative" role="progressbar"
                        aria-valuenow="{{ $simple->progress }}" aria-valuemin="0" aria-valuemax="100"
                        style="height: 20px">
                        <div class="progress-bar bg-primary" style="width: {{ $simple->progress }}%">
                        </div>
                        <span
                          class="progress-text fw-bold fs-6 {{$simple->progress > 35 ? 'text-white' : 'text-primary'}}">
                          {{ $simple->progress }}%
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer p-0">
            <table class="table table-striped table-hover m-0 py-3" id="myTable">
              <thead>
                <tr class="text-center align-middle">
                  <th scope="col">Trạm</th>
                  <th scope="col">Tên trạm</th>
                  <th scope="col">Trạng thái</th>
                  <th class="text-start" scope="col">Thời gian lưu tại trạm</th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach($data as $each)
                <tr data-id="{{ $each->PathImage }}">
                  <td class="text-center">{{ $each->Name_Station }}</td>
                  <td>{{ $each->Name_StationType }}</td>
                  <td class="text-center">{{ $each->status }}</td>
                  <td class="text-start">{{ $each->elapsedTime }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
        </div>
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
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@endsection

@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script>
  $(document).ready(function () {
    let rowElement = $("#table-data tr");
    let imgElement = $("#img-js");

    rowElement.hover(
      function () {
        let id = $(this).data("id");
        let src = "{{ asset('') }}" + '/' + id;
        imgElement.removeClass("d-none");
        imgElement.attr("src", src);
      },
      function () {
        imgElement.addClass("d-none");
        imgElement.attr("src", "");
      }
    );
  });
</script>
@endpush