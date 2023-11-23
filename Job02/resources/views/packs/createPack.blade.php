@extends('layouts.master')

@section('title', 'Thêm thùng hàng vào gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin thùng hàng</h4>
          </div>
          <h1>{{ session('count') }}</h1>
          <div class="card-body">
            <input type="hidden" name="FK_Id_Order" value="{{ $_GET['id'] }}">
            <form method="POST" id="formProduct">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_RawMaterial" style="width: 130px;">
                      Nguyên vật liệu
                    </label>
                    <select name="FK_Id_RawMaterial" id="FK_Id_RawMaterial" class="form-select">
                      @foreach($materials as $each)
                      <option value="{{ $each->Id_RawMaterial }}" data-name="{{ $each->Name_RawMaterial }}">
                        {{ $each->Name_RawMaterial }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3 align-items-center ">
                    <label class="input-group-text bg-secondary-subtle" for="Count_RawMaterial">
                      Số lượng nguyên vật liệu
                    </label>
                    <input type="number" name="Count_RawMaterial" id="Count_RawMaterial" class="form-control" min="1"
                      value='1'>
                    <p data-name="unit" class="m-0 ps-3"></p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_ID_ContainerType" style="width: 130px;">
                      Thùng chứa
                    </label>
                    <select class="form-select selectValidate" name="FK_ID_ContainerType" id="FK_ID_ContainerType">
                      @foreach($containers as $each)
                      <option value="{{ $each->Id_ContainerType }}" data-name="{{ $each->Name_ContainerType }}">
                        {{ $each->Name_ContainerType }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Count_Container">
                      Số lượng thùng chứa
                    </label>
                    <input type="number" name="Count_Container" id="Count_Container" class="form-control" min="1"
                      value='1'>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Price_Container">
                      Đơn giá
                    </label>
                    <input type="number" name="Price_Container" id="Price_Container" class="form-control" min="1"
                      value='1'>
                  </div>
                </div>
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary-color mb-3 px-5">
                    <i class="fa-solid fa-plus text-white"></i>
                    Thêm sản phẩm
                  </button>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Count_Pack">
                      Số lượng gói hàng
                    </label>
                    <input type="number" name="Count_Pack" id="Count_Pack" class="form-control" min="1" value='1'>
                  </div>
                </div>
            </form>
          </div>
          <div class="card-footer p-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th style="width: 150px;" scope="col">Nguyên liệu</th>
                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col">Đơn vị</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end my-3 me-3">
          <button type="submit" class="btn btn-primary-color px-4" id="saveBtn">Lưu gói hàng</button>
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
<script src="{{ asset('js/packs/createPack.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script>
@endpush