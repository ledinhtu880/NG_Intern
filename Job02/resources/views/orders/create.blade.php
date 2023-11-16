@extends('layouts.master')

@section('title', 'Tạo đơn hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <form method="POST" id="formInformation">
              @csrf
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <label class="input-group-text bg-secondary-subtle" for="customerSelect"
                          style="width: 95px;">Customer</label>
                        <select class="form-select selectValidate" id="customerSelect" name="FK_Id_Customer">
                          <option value="" selected>Choose a customer</option>
                          @foreach($customers as $each)
                          <option value="{{ $each->Id_Customer }}">{{ $each->Name_Customer }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <label class="input-group-text bg-secondary-subtle" for="typeSelect" style="width: 95px;">
                          Order
                        </label>
                        <select class="form-select selectValidate" name="FK_Id_OrderType" id="typeSelect">
                          <option value="" selected>Choose a order Type</option>
                          @foreach($types as $each)
                          <option value="{{ $each->Id_OrderType }}">{{ $each->Name_OrderType }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    .
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <div class="input-group">
                          <label class="input-group-text bg-secondary-subtle" style="width: 135px;">Order Date</label>
                          <input type="date" class="form-control" id="Date_Order" name="Date_Order">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <div class="input-group">
                          <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                            Delivery Date
                          </label>
                          <input type="date" class="form-control" id="Date_Delivery" name="Date_Delivery">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <div class="input-group">
                          <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                            Reception Date
                          </label>
                          <input type="date" class="form-control" id="Date_Reception" name="Date_Reception">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-text bg-secondary-subtle">Note</span>
                    <textarea class="form-control" style="height: 146px;" aria-label="Notes" name="Note"
                      rows="5"></textarea>
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
            <form method="POST" id="formProduct">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_RawMaterial" style="width: 95px;">
                      Material
                    </label>
                    <select name="FK_Id_RawMaterial" id="FK_Id_RawMaterial" class="form-select">
                      <option value="" selected>Choose a materials</option>
                      @foreach($materials as $each)
                      <option value="{{ $each->Id_RawMaterial }}" data-name="{{ $each->Name_RawMaterial }}">
                        {{ $each->Name_RawMaterial }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Count_RawMaterial" style="width: 155px;">
                      Material Number
                    </label>
                    <input type="number" name="Count_RawMaterial" id="Count_RawMaterial" class="form-control" min="0">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_ID_ContainerType" style="width: 95px;">
                      Container
                    </label>
                    <select class="form-select selectValidate" name="FK_ID_ContainerType" id="FK_ID_ContainerType">
                      <option value="" selected>Choose a container</option>
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
                      Container Number
                    </label>
                    <input type="number" name="Count_Container" id="Count_Container" class="form-control" min="0">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Price_Container">
                      Price
                    </label>
                    <input type="number" name="Price_Container" id="Price_Container" class="form-control" min="0">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-check">
                      <input class="form-check-input border-secondary" type="checkbox" name="ContainerProvided"
                        id="ContainerProvided">
                      <label class="form-check-label" for="ContainerProvided">
                        Container Provided
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-check">
                      <input class="form-check-input border-secondary" type="checkbox" name="PedestalProvided"
                        id="PedestalProvided">
                      <label class="form-check-label" for="PedestalProvided">
                        Pedestal Provided
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-check">
                      <input class="form-check-input border-secondary" type="checkbox" name="RFIDProvided"
                        id="RFIDProvided">
                      <label class="form-check-label" for="RFIDProvided">
                        RFID Provided
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-check">
                      <input class="form-check-input border-secondary" type="checkbox" name="RawMaterialProvided"
                        id="RawMaterialProvided">
                      <label class="form-check-label" for="RawMaterialProvided">
                        Raw Material Provided
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-secondary mt-3 px-5">
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
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Giá thùng chứa</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end mt-3">
          <button type="submit" class="btn btn-lg btn-primary-color px-4" id="saveBtn">Lưu</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('javascript')
<script>
  $(document).ready(function () {
    let count = 0;
    $("#formProduct").on('submit', function (event) {
      event.preventDefault();
      let token = $('meta[name="csrf-token"]').attr('content');
      let form = $(this);
      let url = "{{ route('order.addProduct') }}"

      $.ajax({
        url: url,
        type: 'post',
        data: {
          formData: form.serialize(),
          _token: token
        },
        success: function (response) {
          count++;
          let ContainerProvided;
          let PedestalProvided;
          let RFIDProvided;
          let RawMaterialProvided;
          response.data[0].hasOwnProperty('ContainerProvided') ? ContainerProvided = 1 : ContainerProvided = 0
          response.data[0].hasOwnProperty('PedestalProvided') ? PedestalProvided = 1 : PedestalProvided = 0
          response.data[0].hasOwnProperty('RFIDProvided') ? RFIDProvided = 1 : RFIDProvided = 0
          response.data[0].hasOwnProperty('RawMaterialProvided') ? RawMaterialProvided = 1 : RawMaterialProvided = 0
          let htmls = "";
          $.each(response.data, function (key, value) {
            let rawMaterialId = value.FK_Id_RawMaterial;
            let rawMaterialName = $('#FK_Id_RawMaterial option[value="' + rawMaterialId + '"]').data('name');

            let containerTypeId = value.FK_ID_ContainerType;
            let containerTypeName = $('#FK_ID_ContainerType option[value="' + containerTypeId + '"]').data('name');
            htmls += '<tr data-id="' + count + '">' +
              '<td class="text-center" data-id="rawMaterialId" data-value="' + rawMaterialId + '">' + rawMaterialName + '</td>' +
              '<td class="text-center" data-id="Count_RawMaterial" data-value="' + value.Count_RawMaterial + '">' + value.Count_RawMaterial + '</td>' +
              '<td class="text-center" data-id="containerTypeId" data-value="' + containerTypeId + '">' + containerTypeName + '</td>' +
              '<td class="text-center" data-id="Count_Container" data-value="' + value.Count_Container + '">' + value.Count_Container + '</td>' +
              '<td class="text-center" data-id="Price_Container" data-value="' + value.Price_Container + '">' + value.Price_Container + '</td>' +
              '<input type="hidden" name="ContainerProvided" value="' + ContainerProvided + '">' +
              '<input type="hidden" name="PedestalProvided" value="' + PedestalProvided + '">' +
              '<input type="hidden" name="RFIDProvided" value="' + RFIDProvided + '">' +
              '<input type="hidden" name="RawMaterialProvided" value="' + RawMaterialProvided + '">' +
              '<td>' +
              '<button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#deleteRow' + count + '">' +
              '<i class="fa-solid fa-trash"></i>' +
              '</button>' +
              '<div class="modal fade" id="deleteRow' + count + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
              '<div class="modal-dialog">' +
              '<div class="modal-content">' +
              '<div class="modal-header">' +
              '<h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>' +
              '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
              '</div>' +
              '<div class="modal-body">' +
              'Bạn có chắc chắn về việc sản phẩm này' +
              '</div>' +
              '<div class="modal-footer">' +
              '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>' +
              '<button type="button" class="btn btn-danger btnDelete" data-id="' + count + '">Xóa</button>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '</td>' +
              '</tr>';

          });
          $("#table-data").append(htmls);

          // Xóa dữ liệu đã nhập/chọn trong form
          form[0].reset();
        },
      });
    });
    $("#saveBtn").on('click', function () {
      let token = $('meta[name="csrf-token"]').attr('content');
      let form = $("#formInformation");
      let formData = form.serialize();
      let url = "{{ route('order.storeOrder') }}";

      $.ajax({
        url: url,
        type: 'post',
        data: {
          formData: formData,
          _token: token
        },
        success: function (response) {
          let secondUrl = "{{ route('order.storeProduct')}}";
          let rowDataArray = [];
          $("#table-data tr").each(function () {
            let row = $(this);
            let rowData = {};

            rowData.FK_Id_RawMaterial = row.find('td[data-id="rawMaterialId"]').data('value');
            rowData.Count_RawMaterial = row.find('td[data-id="Count_RawMaterial"]').data('value');
            rowData.FK_Id_ContainerType = row.find('td[data-id="containerTypeId"]').data('value');
            rowData.Count_Container = row.find('td[data-id="Count_Container"]').data('value');
            rowData.Price_Container = row.find('td[data-id="Price_Container"]').data('value');
            rowData.ContainerProvided = row.find('input[name="ContainerProvided"]').val();
            rowData.PedestalProvided = row.find('input[name="PedestalProvided"]').val();
            rowData.RFIDProvided = row.find('input[name="RFIDProvided"]').val();
            rowData.RawMaterialProvided = row.find('input[name="RawMaterialProvided"]').val();
            rowData.FK_Id_Order = response.id;

            rowDataArray.push(rowData);
          });

          $.ajax({
            url: secondUrl,
            type: 'post',
            data: {
              rowData: rowDataArray,
              _token: token
            },
            success: function (response) {
              // Điều hướng về trang chủ
              window.location.href = '/orders/';
              // Lưu session 'Thêm đơn hàng thành công'
              sessionStorage.setItem('type', 'success');
              sessionStorage.setItem('message', 'Thêm đơn hàng thành công');
            },
            error: function (xhr) {
              // Xử lý lỗi khi gửi yêu cầu Ajax
              console.log(xhr.responseText);
              alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            }
          });
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
      });
    });
    $(document).on('click', '.btnDelete', function () {
      let id = $(this).data('id');
      let rowElement = $(this).closest('tr[data-id="' + id + '"]');
      let modalElement = $('#deleteRow' + id); // Lấy modal tương ứng với hàng

      modalElement.on('hidden.bs.modal', function () {
        // Xóa hàng khi modal được ẩn
        rowElement.remove();
      });

      // Đóng modal
      modalElement.modal('hide');
    });
  });
</script>
@endpush