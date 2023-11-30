@extends('layouts.master')

@section('title', 'Sửa đơn thùng hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orders.index') }}">Quản lý đơn thùng hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa đơn thùng hàng</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <form method="POST" id="formInformation">
              @csrf
              <input type="hidden" name="Id_Order" value="{{ $order->Id_Order }}">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" for="FK_Id_Customer"
                          style="width: 130px;">Khách hàng</label>
                        <select class="form-select selectValidate" id="FK_Id_Customer" name="FK_Id_Customer">
                          @foreach($customers as $each)
                          @if($each->Id_Customer == $order->FK_Id_Customer)
                          <option value="{{ $each->Id_Customer }}" selected>{{ $each->Name_Customer }}</option>
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
                        <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                          value="{{ \Carbon\Carbon::parse($order->Date_Order)->format('Y-m-d') }}">
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
                        <input type="date" class="form-control" id="Date_Dilivery" name="Date_Dilivery"
                          value="{{ \Carbon\Carbon::parse($order->Date_Dilivery)->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                          Ngày nhận hàng
                        </label>
                        <input type="date" class="form-control" id="Date_Reception" name="Date_Reception"
                          value="{{ \Carbon\Carbon::parse($order->Date_Reception)->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-text bg-secondary-subtle">Ghi chú</span>
                    <textarea class="form-control" style="height: 91px;" aria-label="Notes" name="Note"
                      rows="5">{{ $order->Note}}</textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin thùng hàng</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col" width="200">Nguyên liệu</th>
                  <th class="text-center" scope="col" width="200">Số lượng nguyên liệu</th>
                  <th class="text-center" scope="col" width="100">Đơn vị</th>
                  <th class="text-center" scope="col" width="200">Thùng chứa</th>
                  <th class="text-center" scope="col" width="200">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col" width="200">Đơn giá thùng chứa</th>
                  <th class="text-center" scope="col" width="200">Thành tiền</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach($data as $each)
                <tr class="js-row" data-id="{{ $each->Id_SimpleContent }}">
                  <td>
                    <select class="form-select selectValidate" id="FK_Id_RawMaterial" name="FK_Id_RawMaterial">
                      @foreach($materials as $material)
                      @if($each->FK_Id_RawMaterial == $material->Id_RawMaterial)
                      <option value="{{ $material->Id_RawMaterial }}" selected>{{ $material->Name_RawMaterial }}
                      </option>
                      @else
                      <option value="{{ $material->Id_RawMaterial }}">{{ $material->Name_RawMaterial }}</option>
                      @endif
                      @endforeach
                    </select>
                  </td>
                  <td class="text-center">
                    <input class="form-control" type="number" name="Count_RawMaterial" id="Count_RawMaterial"
                      value="{{ $each->Count_RawMaterial}}" min="0">
                  </td>
                  <td class="text-center" data-name="unit">{{ $each->Unit}}</td>
                  <td class="text-center">
                    <select class="form-select selectValidate" id="FK_Id_ContainerType" name="FK_Id_ContainerType">
                      @foreach($containers as $container)
                      @if($container->Id_ContainerType == $each->FK_Id_ContainerType)
                      <option value="{{ $container->Id_ContainerType }}" selected>{{ $container->Name_ContainerType }}
                      </option>
                      @else
                      <option value="{{ $container->Id_ContainerType }}">{{ $container->Name_ContainerType }}</option>
                      @endif
                      @endforeach
                    </select>
                  </td>
                  <td class="text-center">
                    <input class="form-control" type="number" name="Count_Container" id="Count_Container"
                      value="{{ $each->Count_Container}}" min="0">
                  </td>
                  <td class="text-center">
                    <input class="form-control" type="number" name="Price_Container" id="Price_Container"
                      value="{{ number_format($each->Price_Container, 0, '', '')}}" min="0">
                  </td>
                  <td class="text-center" data-id="total">
                    {{ number_format($each->Price_Container * $each->Count_Container, 0, ',', '.'). ' VNĐ' }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                      data-bs-toggle="modal" data-bs-target="#deleteID-{{$each->Id_SimpleContent}}">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal fade" id="deleteID-{{$each->Id_SimpleContent}}" tabindex="-1"
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
                              data-id="{{$each->Id_SimpleContent}}">Xóa</button>
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
          <div class="card-footer d-flex align-items-center justify-content-end gap-3">
            <a href="{{ route('orders.index') }}" class="btn btn-warning">Quay lại</a>
            <button type="submit" class="btn btn-primary-color px-4" id="saveBtn">Lưu</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('javascript')
<script src="{{ asset('js/simples/editSimple.js') }}"></script>
<script>
  $(document).ready(function () {
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    selectElement.on("change", function () {
      let token = $('meta[name="csrf-token"]').attr("content");
      let id = $(this).val();
      let rowElement = $(this).closest(".js-row");
      $.ajax({
        url: "/rawMaterials/showUnit",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          _token: token,
        },
        success: function (data) {
          let unitElement = rowElement.find("[data-name='unit']");
          unitElement.html(data.unit);
        },
      });
    });
  });
</script>
@endpush