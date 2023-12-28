@extends('layouts.master')

@section('title', 'Sửa đơn sản xuất')
@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        @if(session('type'))
        <input type="hidden" name="checkFlash" value="1">
        @endif
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn sản xuất</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa đơn sản xuất</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('orderLocals.makes.update', $orderLocal) }}" method="POST" id="formInformation">
              @csrf
              @method('PUT')
              <input type="hidden" name="Id_OrderLocal" value="{{ $orderLocal->Id_OrderLocal }}">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" for="Count">
                      Số lượng
                    </label>
                    <input type="number" name="Count" id="Count" class="form-control" min="0"
                      value="{{ $orderLocal->Count }}">
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" for="MakeOrPackOrExpedition">
                      Trạng thái
                    </label>
                    <select class="form-select selectValidate" id="MakeOrPackOrExpedition"
                      name="MakeOrPackOrExpedition">
                      @if($orderLocal->MakeOrPackOrExpedition == 0)
                      <option value="0" selected>Sản xuất</option>
                      <option value="1">Gói hàng</option>
                      <option value="2">Giao hàng</option>
                      @elseif($orderLocal->MakeOrPackOrExpedition == 1)
                      <option value="0">Sản xuất</option>
                      <option value="1" selected>Gói hàng</option>
                      <option value="2">Giao hàng</option>
                      @elseif($orderLocal->MakeOrPackOrExpedition == 2)
                      <option value="0">Sản xuất</option>
                      <option value="1">Gói hàng</option>
                      <option value="2" selected>Giao hàng</option>
                      @endif
                    </select>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                      Ngày giao hàng
                    </label>
                    <input type="date" class="form-control" id="Date_Delivery" name="Date_Delivery"
                      value="{{ \Carbon\Carbon::parse($orderLocal->Date_Delivery)->format('Y-m-d') }}">
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" for="Date_Start">
                      Ngày bắt đầu
                    </label>
                    <input type="date" class="form-control" id="Date_Start" name="Date_Start"
                      value="{{ \Carbon\Carbon::parse($orderLocal->Date_Start)->format('Y-m-d') }}">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chi tiết</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered m-0">
              <thead>
                <tr>
                  <th scope="col">Nguyên liệu</th>
                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col">Đơn vị</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá thùng chứa</th>
                  <th class="text-center" scope="col">Thành tiền</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach($data as $each)
                <tr data-id="{{ $each->Id_ContentSimple }}">
                  <td>{{ $each->Name_RawMaterial}}</td>
                  <td class="text-center">{{ $each->Count_RawMaterial}}</td>
                  <td class="text-center">{{ $each->Unit}}</td>
                  <td class="text-center">{{ $each->Name_ContainerType}}</td>
                  <td class="text-center">{{ $each->Count_Container}}</td>
                  <td class="text-center">
                    {{ number_format($each->Price_Container, 0, '', '')}}
                  </td>
                  <td class="text-center">
                    {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.'). ' VNĐ' }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                      data-bs-toggle="modal" data-bs-target="#deleteID-{{$each->Id_ContentSimple}}">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal fade" id="deleteID-{{$each->Id_ContentSimple}}" tabindex="-1"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Bạn có chắc chắn về việc sản phẩm này
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-danger btnDelete"
                              data-id="{{$each->Id_ContentSimple}}">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center justify-content-between gap-2">
            <a href="{{  route('orderLocals.makes.addSimple', $orderLocal) }}" class="btn btn-primary-color">
              Thêm thùng hàng
            </a>
            <div class="d-flex gap-2">
              <a href="{{ route('orderLocals.makes.index') }}" class="btn btn-warning">Quay lại</a>
              <button type="submit" class="btn btn-primary-color" id="updateBtn">Lưu</button>
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