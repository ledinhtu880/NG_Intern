@extends('layouts.master')

@section('title', 'Thêm thùng hàng vào gói hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Tạo đơn thùng hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="/orders/packs/create?id={{ $_GET['id'] }}">Thêm</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm thùng hàng vào gói hàng</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Thông tin thùng hàng</h5>
      </div>
      <div class="card-body border-0">
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
                <label class="input-group-text bg-secondary-subtle" for="FK_Id_ContainerType" style="width: 130px;">
                  Thùng chứa
                </label>
                <select class="form-select selectValidate" name="FK_Id_ContainerType" id="FK_Id_ContainerType">
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
                <input type="number" name="Count_Container" id="Count_Container" class="form-control" min="1" value='1'>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-3">
                <label class="input-group-text bg-secondary-subtle" for="Price_Container">
                  Đơn giá
                </label>
                <input type="number" step="0.01" name="Price_Container" id="Price_Container" class="form-control"
                  min="1" value='1'>
              </div>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary mb-3 px-5">
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
          </div>
        </form>
        <table class="table mt-4">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3">Nguyên liệu</th>
              <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
              <th scope="col" class="py-3">Đơn vị</th>
              <th scope="col" class="py-3">Thùng chứa</th>
              <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
              <th scope="col" class="py-3 text-center">Đơn giá</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="table-data">
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="d-flex align-items-center justify-content-end gap-3">
          <a href="/orders/packs/create?id={{ $_GET['id'] }}" class="btn btn-lg btn-light px-3 fs-6">Quay
            lại</a>
          <button type="submit" class="btn btn-lg btn-primary px-3 fs-6" id="saveBtn">Lưu gói hàng</button>
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
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script>
<script src="{{ asset('js/orders/packs/create.js') }}"></script>
<script>
  $(document).ready(function () {
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    let token = $('meta[name="csrf-token"]').attr("content");
    $("#formProduct").on("submit", function (event) {
      let urlParams = new URLSearchParams(window.location.search);
      let id = urlParams.get("id");

      event.preventDefault();
      let form = $(this);
      let url = "/orders/packs/addSimpleToPack";
      let unit = $("p[data-name='unit']").html();
      $.ajax({
        url: url,
        type: "post",
        data: {
          id: id,
          unit: unit,
          formData: form.serialize(),
          _token: token,
        },
        success: function (response) {
          let htmls = "";
          let id = parseInt(response.maxID);
          if (response.exists == 0) {
            $.each(response.data, function (key, value) {
              let rawMaterialId = value.FK_Id_RawMaterial;
              let rawMaterialName = $(
                `#FK_Id_RawMaterial option[value="${rawMaterialId}"]`
              ).data("name");
              let containerTypeId = value.FK_Id_ContainerType;
              let containerTypeName = $(
                `#FK_Id_ContainerType option[value="${containerTypeId}"]`
              ).data("name");
              htmls += `<tr data-id="${id}">
                        <td data-id="rawMaterialId" data-value="${rawMaterialId}">
                            ${rawMaterialName}
                        </td>
                        <td class="text-center" data-id="Count_RawMaterial" data-value="${value.Count_RawMaterial}">
                            ${value.Count_RawMaterial}
                        </td>
                        <td>${value.unit}</td>
                        <td data-id="containerTypeId" data-value="${containerTypeId}">
                            ${containerTypeName}
                        </td>
                        <td class="text-center" data-id="Count_Container" data-value="${value.Count_Container}">
                            ${value.Count_Container}
                        </td>
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${value.formattedPrice}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#deleteRow${id}">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="modal fade" id="deleteRow${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <button type="button" class="btn btn-danger btnDelete" data-id="${id}">Xóa</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        </tr>`;
            });
            $("#table-data").append(htmls);
            // Xóa dữ liệu đã nhập/chọn trong form
            form[0].reset();
          } else if (response.exists == 1) {
            let existingRow = $(`#table-data tr[data-id="${response.existsData.Id_ContentSimple}"]`);
            existingRow.find('[data-id="Count_RawMaterial"]').text(response.existsData.Count_RawMaterial);
            existingRow.find('[data-id="Count_Container"]').text(response.existsData.Count_Container);
            existingRow.find('[data-id="Price_Container"]').text(response.existsData.formattedPrice);
          }

          $("#icon").addClass("fa-check-circle");
          $(".toast-body").addClass("bg-success");
          $("#toast-msg").html("Thêm thùng hàng thành công");
          toastBootstrap.show();
        },
      });
    });
    $(document).on("click", ".btnDelete", function () {
      let id = $(this).data("id");
      let modalElement = $("#deleteRow" + id); // Lấy modal tương ứng với hàng
      let rowElement = $(this).closest('tr[data-id="' + id + '"]');

      // Xóa hàng khi modal được ẩn
      $.ajax({
        url: "/orders/simples/deleteSimple",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          _token: token,
        },
        success: function (data) {
          modalElement.on("hidden.bs.modal", function () {
            $(".toast-body").addClass("bg-success");
            $("#icon").addClass("fa-check-circle");
            $("#toast-msg").html("Xóa thùng hàng thành công");
            toastBootstrap.show();
            rowElement.remove();
          });

          // Đóng modal
          modalElement.modal("hide");
        },
      });
    });
    $("#saveBtn").on("click", function () {
      let rowElement = $("#table-data tr");
      if (rowElement.length > 0) {
        let order_Id = $("input[name='FK_Id_Order']").val();
        let rowDataArray = [];
        let Price_Pack = 0;
        let idArr = [];
        $("#table-data tr").each(function () {
          let row = $(this);
          let rowData = {};
          var Id_ContentSimple = row.attr("data-id");
          rowData.Id_ContentSimple = Id_ContentSimple;
          rowData.FK_Id_RawMaterial = row
            .find('td[data-id="rawMaterialId"]')
            .data("value");
          rowData.Count_RawMaterial = row
            .find('td[data-id="Count_RawMaterial"]')
            .data("value");
          rowData.FK_Id_ContainerType = row
            .find('td[data-id="containerTypeId"]')
            .data("value");
          rowData.Count_Container = row
            .find('td[data-id="Count_Container"]')
            .data("value");
          rowData.Price_Container = row
            .find('td[data-id="Price_Container"]')
            .data("value");
          rowData.FK_Id_Order = order_Id;
          rowDataArray.push(rowData);
          idArr.push(Id_ContentSimple);

          let subtotal = rowData.Count_Container * rowData.Price_Container; // Tính subtotal
          Price_Pack += subtotal;
        });
        let countPack = $("input[name='Count_Pack'");
        let countValue = countPack.val();
        let packData = {
          Count_Pack: countValue,
          Price_Pack: Price_Pack,
          FK_Id_Order: order_Id,
        };
        let secondUrl = "/orders/packs/store";
        $.ajax({
          url: secondUrl,
          type: "post",
          data: {
            packData: packData,
            _token: token,
          },
          success: function (response) {
            let thirdUrl = "/orders/packs/storeDetail";
            let Id_ContentPack = response.id;
            $.ajax({
              url: thirdUrl,
              type: "post",
              data: {
                FK_Id_Order: order_Id,
                Id_ContentPack: Id_ContentPack,
                idArr: idArr,
                _token: token,
              },
              success: function (response) {
                window.location.href =
                  "/orders/packs/create?id=" + response.id;
              },
              error: function (xhr) {
                $(".toast-body").addClass("bg-danger");
                $("#icon").addClass("fa-xmark-circle");
                $("#toast-msg").html("Vui lòng thêm ít nhất 1 thùng hàng");
                toastBootstrap.show();
                rowElement.remove();

                // Đóng modal
                modalElement.modal("hide");
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
              },
            });
          },
          error: function (xhr) {
            // Xử lý lỗi khi gửi yêu cầu Ajax
            console.log(xhr.responseText);
            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
          },
        });

      }
      else {
        $(".toast-body").addClass("bg-warning");
        $("#icon").addClass("fa-xmark-circle");
        $("#toast-msg").html("Bạn chưa thêm thùng hàng nào");
        toastBootstrap.show();
      }
    });
  })
</script>
@endpush