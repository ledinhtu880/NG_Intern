@extends('layouts.master')

@section('title', 'Thêm thùng hàng vào đơn sản xuất')
@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
            </li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orderLocals.makes.edit', $id) }}">
                Sửa đơn sản xuất
              </a>
            </li>
            <li class=" breadcrumb-item active" aria-current="page">Thêm thùng hàng vào đơn sản xuất
            </li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thùng hàng</h4>
          </div>
          <div class="card-body px-0">
            <input type="hidden" name="Id_OrderLocal" value="{{ $id }}">
            <table class="table table-striped m-0">
              <thead id="table-heading">
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Khách hàng</th>
                  <th class="text-center" scope="col">Nguyên liệu</th>
                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá thùng chứa</th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach($data as $each)
                <td class="d-flex justify-content-center" data-id="Id_ContentSimple"
                  data-value="{{$each->Id_ContentSimple}}">
                  <input type="checkbox" class="checkbox form-check-input" name="firstFormCheck"
                    id="firstFormCheck-{{$each->Id_ContentSimple}}">
                </td>
                <td data-id="Name_Customer" data-value="{{$each->Name_Customer}}" class="text-center text-truncate"
                  style="max-width: 200px; width: 200px;">
                  {{$each->Name_Customer}}
                </td>
                <td data-id="Name_RawMaterial" data-value="{{$each->Name_RawMaterial}}" class="text-center">
                  {{$each->Name_RawMaterial}}
                </td>
                <td data-id="Count_RawMaterial" data-value="{{$each->Count_RawMaterial}}" class="text-center">
                  {{$each->Count_RawMaterial}}
                </td>
                <td data-id="Name_ContainerType" data-value="{{$each->Name_ContainerType}}" class="text-center">
                  {{$each->Name_ContainerType}}
                </td>
                <td data-id="Count_Container" data-value="{{$each->Count_Container}}" class="text-center">
                  {{$each->Count_Container}}
                </td>
                <td data-id="Price_Container" data-value="{{$each->Price_Container}}" class="text-center">
                  {{ number_format($each->Price_Container, 0, '', '')}} VNĐ
                </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex align-content-center justify-content-end gap-3">
              <a href="{{ route('orderLocals.makes.edit', $id) }}" class="btn btn-warning px-3">Quay lại</a>
              <button type="submit" class="btn btn-primary-color" id="storeSimpleBtn">Lưu</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex align-items-center justify-content-between">
      <div class="d-flex justify-content-center align-items-center gap-2">
        <i id="icon" class="fas text-light fs-5"></i>
        <h6 id="toast-msg" class="h6 text-white m-0"></h6>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('javascript')
<script src="{{ asset('js/orderLocals/makes/edit.js') }}"></script>
@endpush