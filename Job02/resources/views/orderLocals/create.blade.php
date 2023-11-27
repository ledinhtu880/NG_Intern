@extends('layouts.master')

@section('title', 'Tạo đơn sản xuất')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thùng hàng</h4>
          </div>
          <div class="card-body px-0">
            <div class="px-3 mb-3 d-flex justify-content-between align-items-center">
              <div class="input-group" style="width: 325px;">
                <label class="input-group-text bg-secondary-subtle" for="FK_Id_CustomerType">Loại khách hàng</label>
                <select name="FK_Id_CustomerType" id="FK_Id_CustomerType" class="form-select">
                  @foreach($customerType as $each)
                  <option value="{{ $each->Id }}">{{ $each->Name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-group" style="width: 325px;">
                <label class="input-group-text bg-secondary-subtle" for="SimpleOrPack">Kiểu hàng</label>
                <select name="SimpleOrPack" id="SimpleOrPack" class="form-select">
                  <option value="0">Thùng hàng</option>
                  <option value="1">Gói hàng</option>
                </select>
              </div>
            </div>
            <table class="table table-striped m-0">
              <thead id="table-heading">
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex align-content-center justify-content-between">
              <button type="submit" class="btn btn-primary-color px-3" id="addBtn">
                <i class="fa-solid fa-plus text-white me-2"></i>Thêm
              </button>
              <div class="input-group" style="width: 300px;">
                <label class="input-group-text bg-secondary-subtle" for="DateDilivery">
                  Ngày giao hàng
                </label>
                <input type="date" name="DateDilivery" id="DateDilivery" class="form-control"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Đơn sản xuất</h4>
          </div>
          <div class="card-body px-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Mã đơn hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Kiểu hàng</th>
                  <th class="text-center" scope="col">Ngày giao hàng</th>
                  <th class="text-center" scope="col">Mô tả</th>
                </tr>
              </thead>
              <tbody id="table-result">
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary-color px-3" id="deleteBtn">
              <i class="fa-solid fa-minus text-white me-2"></i>Xóa
            </button>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end my-3 me-3">
          <a href="{{ route('orderLocals.index')}}" class="btn btn-primary-color px-4">Lưu</a>
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
<script src="{{ asset('js/orderLocals/create.js') }}"></script>
@endpush