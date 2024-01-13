@extends('layouts.master')

@section('title', 'Sửa trạm')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Sửa thông tin trạm</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('stations.index') }}">Quản lý trạm</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form method="POST" action="{{ route('stations.update', compact('station')) }}">
          @csrf
          <div class="d-flex gap-3">
            <div class="form-group" style="flex: 1;">
              <label for="Id_Station" class="form-label">Mã trạm</label>
              <input type="text" name="Id_Station" id="Id_Station" placeholder="Nhập mã trạm"
                class="form-control{{ $errors->has('Id_Station') ? ' is-invalid' : '' }}"
                value="{{ $station->Id_Station }}" readonly>
              @if ($errors->has('Id_Station'))
              <span class="text-danger">
                {{ $errors->first('Id_Station') }}
              </span>
              @endif
            </div>
            @method('PUT')
            <div class="form-group" style="flex: 1;">
              <label for="Name_Station" class="form-label">Tên trạm</label>
              <input type="text" name="Name_Station" id="Name_Station" placeholder="Nhập tên trạm"
                class="form-control{{ $errors->has('Name_Station') ? ' is-invalid' : '' }}"
                value="{{ $station->Name_Station }}">
              @if ($errors->has('Name_Station'))
              <span class="text-danger">
                {{ $errors->first('Name_Station') }}
              </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label for="Ip_Address" class="form-label">Địa chỉ IP</label>
            <input type="text" name="Ip_Address" id="Ip_Address" placeholder="Nhập địa chỉ IP"
              class="form-control{{ $errors->has('Ip_Address') ? ' is-invalid' : '' }}"
              value="{{ $station->Ip_Address }}">
            @if ($errors->has('Ip_Address'))
            <span class="text-danger">
              {{ $errors->first('Ip_Address') }}
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="FK_Id_StationType" class="form-label">Loại trạm</label>
            <select name="FK_Id_StationType" id="FK_Id_StationType"
              class="form-select{{ $errors->has('FK_Id_StationType') ? ' is-invalid' : '' }}">
              @foreach ($data as $each)
              <option value="{{ $each->Id_StationType }}" @if ($each->Id_StationType == $station->FK_Id_StationType)
                selected @endif>
                {{ $each->Name_StationType }}</option>
              @endforeach
            </select>
            @if ($errors->has('FK_Id_StationType'))
            <span class="text-danger">
              {{ $errors->first('FK_Id_StationType') }}
            </span>
            @endif
          </div>
          <!-- <div class="mt-3">
            <div class="d-flex align-items-center justify-content-center ">
              <img src="{{ asset($station->stationType->PathImage) }}" class="img-thumbnail img-change me-3">
            </div>
          </div> -->
          <div class="d-flex justify-content-end my-4 gap-3">
            <a href="{{ route('stations.index') }}" class="btn btn-light">Quay lại</a>
            <button type="submit" class="btn btn-primary">Sửa</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('javascript')
<script type="text/javascript">
  $(document).ready(function () {
    $("#FK_Id_StationType").on('change', function () {
      let id = $(this).val();
      $.ajax({
        url: "/getImgByStationType",
        type: "POST",
        data: {
          _token: $("meta[name='csrf-token']").attr("content"),
          id: id
        },
        success: function (data) {
          $(".img-change").attr('src', data.PathImage);
        },
      });
    });
  });
</script>
@endpush