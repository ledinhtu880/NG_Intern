@extends('layouts.master')

@section('title', 'Tạo gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Thêm đơn gói hàng</li>
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
              <input type="hidden" name="SimpleOrPack" value="1">
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
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin gói hàng</h4>
          </div>
          <div class="card-body">
            <button type="submit" class="btn btn-primary-color px-5" id="addBtn">
              <i class="fa-solid fa-plus text-white me-2"></i>Thêm gói hàng
            </button>
          </div>
          <div class="card-footer p-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Mã gói hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-data">
                @if (isset($data))
                @foreach ($data as $each)
                <tr data-id="{{ $each->Id_PackContent }}">
                  <td class="text-center">{{ $each->Id_PackContent }}</td>
                  <td class="text-center">{{ $each->Count_Pack }} gói hàng</td>
                  <td class="text-center">
                    {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                      data-bs-toggle="modal" data-bs-target="#deleteID-{{ $each->Id_PackContent }}">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal fade" id="deleteID-{{ $each->Id_PackContent }}" tabindex="-1"
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
                            <button type="button" class="btn btn-danger deletePack"
                              data-id="{{ $each->Id_PackContent }}">Xóa</button>
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
          <a href="{{ route('orders.packs.index') }}" class="btn btn-lg btn-primary-color px-4" id="btn_save">Lưu</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/orders/packs/create.js') }}"></script>
@endpush