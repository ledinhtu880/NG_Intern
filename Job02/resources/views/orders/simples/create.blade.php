@extends('layouts.master')

@section('title', 'Tạo đơn thùng hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý đơn thùng hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Thêm đơn thùng hàng</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <form method="POST" id="formInformation">
              @csrf
              <input type="hidden" name="count" value="{{ isset($count) ? 1 : 0 }}">
              <input type="hidden" name="SimpleOrPack" value="0">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" for="FK_Id_Customer"
                          style="width: 130px;">Khách hàng</label>
                        <select class="form-select selectValidate" id="FK_Id_Customer" name="FK_Id_Customer">
                          @foreach ($customers as $each)
                          @if (isset($information))
                          @if ($information->FK_Id_Customer == $each->Id_Customer)
                          <option value="{{ $each->Id_Customer }}" selected>{{ $each->Name_Customer }}</option>
                          @else
                          <option value="{{ $each->Id_Customer }}" disabled>{{ $each->Name_Customer }}</option>
                          @endif
                          @else
                          <option value="{{ $each->Id_Customer }}">{{ $each->Name_Customer }}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-12">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 130px;">Ngày đặt hàng</label>
                        <input type="date" class="form-control" id="Date_Order" name="Date_Order" {{ isset($information)
                          ? "readonly" : '' }} value="{{ isset($information) 
                          ? \Carbon\Carbon::parse($information->Date_Order)->format('Y-m-d') 
                          : \Carbon\Carbon::now()->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                          Ngày giao hàng
                        </label>
                        <input type="date" class="form-control" id="Date_Dilivery" name="Date_Dilivery" {{
                          isset($information) ? "readonly" : '' }} value="{{ isset($information) 
                            ? \Carbon\Carbon::parse($information->Date_Dilivery)->format('Y-m-d') 
                            : \Carbon\Carbon::now()->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                          Ngày nhận hàng
                        </label>
                        <input type="date" class="form-control" id="Date_Reception" name="Date_Reception" {{
                          isset($information) ? "readonly" : '' }} value="{{ isset($information) 
                          ? \Carbon\Carbon::parse($information->Date_Reception)->format('Y-m-d') 
                          : \Carbon\Carbon::now()->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-text bg-secondary-subtle">Ghi chú</span>
                    <textarea class="form-control" style="height: 91px;" aria-label="Notes" name="Note" {{
                      isset($information) ? "readonly" : '' }}
                      rows="5">{{ isset($information) ? $information->Note : '' }}</textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary-color px-5" id="redirectBtn">
              <i class="fa-solid fa-warehouse me-2"></i> Lấy thùng hàng từ trong kho
            </button>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin thùng hàng cần sản xuất mới</h4>
          </div>
          <div class="card-body">
            <form method="POST" id="formProduct">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_RawMaterial" style="width: 130px;">
                      Nguyên vật liệu
                    </label>
                    <select name="FK_Id_RawMaterial" id="FK_Id_RawMaterial" class="form-select">
                      @foreach ($materials as $each)
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
                      @foreach ($containers as $each)
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
              </div>
              <button type="submit" class="btn btn-primary-color mt-3 px-5">
                <i class="fa-solid fa-plus text-white"></i>
                Thêm sản phẩm
              </button>
            </form>
          </div>
          <div class="card-footer mt-3 p-0">
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
                @if(isset($data))
                @foreach($data as $each)
                <tr data-id="{{ $each->Id_SimpleContent }}">
                  <td class="text-center" data-id="rawMaterialId" data-value="{{ $each->Id_RawMaterial }}">
                    {{ $each->Name_RawMaterial }}
                  </td>
                  <td class="text-center" data-id="Count_RawMaterial" data-value="{{ $each->Count_RawMaterial  }}">
                    {{ $each->Count_RawMaterial }}
                  </td>
                  <td class="text-center">{{ $each->Unit }}</td>
                  <td class="text-center" data-id="containerTypeId" data-value="{{ $each->Id_ContainerType }}">
                    {{ $each->Name_ContainerType }}
                  </td>
                  <td class="text-center" data-id="Count_Container" data-value="{{ $each->Count_Container }}">
                    {{ $each->Count_Container }}
                  </td>
                  <td class="text-center" data-id="Price_Container" data-value="{{ $each->Price_Container }}">
                    {{ number_format($each->Price_Container, 0, ',', '.'). ' VNĐ' }}
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                      data-bs-toggle="modal" data-bs-target="#deleteID-{{ $each->Id_SimpleContent }}">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal fade" id="deleteID-{{ $each->Id_SimpleContent }}" tabindex="-1"
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
                              data-id="{{ $each->Id_SimpleContent }}">Xóa</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end mt-3">
          <a href="{{ route('orders.simples.index') }}" class="btn btn-lg btn-primary-color px-4">Lưu</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
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

@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/orders/simples/create.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script>
@endpush