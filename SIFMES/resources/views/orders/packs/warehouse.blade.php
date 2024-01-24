@extends('layouts.master')

@section('title', 'Danh sách gói hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Danh sách gói hàng tại kho 409</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="/orders/packs/create?id={{ $_GET['id'] }}">Thêm</a>
      </li>
      <li class=" breadcrumb-item active fw-medium" aria-current="page">Danh sách gói hàng tại kho 409</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h5 class="card-title m-0 fw-bold text-body-secondary">Chi tiết kho chứa</h5>
        <input type="hidden" name="FK_Id_Order" value="{{ $_GET['id'] }}">
        <input type="hidden" name="warehouse" value="409">
      </div>
      <div class="card-body border-0">
        <div class="table-wrapper">
          <table class="table table-bordered border-secondary-subtle">
            <tr class="d-none">
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <div class="d-flex align-items-center justify-content-end">
          <a class="btn btn-light" href="/orders/packs/create?id={{ $_GET['id'] }}">Quay lại</a>
          <button type="submit" class="btn btn-primary" id="saveBtn">Lưu</button>
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
<script>
  $(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    let ware = $("input[name='warehouse']").val();
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

    $.ajax({
      url: "{{ route('wares.showDetails') }}",
      method: 'POST',
      data: {
        ware: ware,
        _token: token,
      },
      success: function (response) {
        if (response == 0) {
          $('#rowNumber').val("");
          $('#colNumber').val("");
        } else {
          var details = response.details;
          var col = response.col;
          var row = response.row;

          $('#rowNumber').val(row);
          $('#colNumber').val(col);
          var count = 0;
          for (var i = 1; i <= row; i++) {

            var newRow = $('<tr></tr>');
            for (var j = 1; j <= col; j++) {
              count++;
              var newCol = $('<td class="position-relative"></td>');
              newCol.addClass("square-cell");
              newCol.attr("data-col", +j);
              newCol.attr("data-row", +i);
              newCol.attr("id", "cell" + count)
              var info = $('<p class="text-end position-absolute top-0 end-0"></p>');
              info.text(i + '.' + j);
              newCol.append(info);
              newRow.append(newCol);
            }

            $('.table').append(newRow);
          }
          for (var i = 1; i <= col * row; i++) {
            if (details[i - 1].FK_Id_StateCell == "0") {
              $('#cell' + i).css("background-color", "#d9d3c4");
              $('#cell' + i).attr("data-status", 0)
              $('#cell' + i).append($(
                '<p class="small">Không thể sử dụng</p>'))
            } else if (details[i - 1].FK_Id_StateCell == "1") {
              $('#cell' + i).css("background-color", "#ffffff");
              $('#cell' + i).attr("data-status", 1);
              $('#cell' + i).append($('<p class="small">Trống</p>'))
            } else if (details[i - 1].FK_Id_StateCell == "2") {
              $('#cell' + i).css("background-color", "#A6BFF7");
              $('#cell' + i).attr("data-status", 0)
              $('#cell' + i).append(
                $(`<p class="small text-truncate" data-id="${details[i - 1].FK_Id_ContentPack}"
                      id="pack-${details[i - 1].FK_Id_ContentPack}">Gói hàng <br> số ${details[i - 1].FK_Id_ContentPack}<br> 
                      <button type="button" class="btnShow btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                      data-bs-target="#show-${details[i - 1].FK_Id_ContentPack}"
                      data-id="${details[i - 1].FK_Id_ContentPack}">
                      <i class="fa-solid fa-eye"></i>
                  </button> </p>`));
              let modals = `
              <div class="modal fade bg-transparent" id="show-${details[i - 1].FK_Id_ContentPack}" tabindex="-1"
                    aria-labelledby="#show-${details[i - 1].FK_Id_ContentPack}Label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-title w-100">
                      <h5 class="modal-title fw-bold text-secondary" id="show-${details[i - 1].FK_Id_ContentPack}Label">
                      Thông tin chi tiết gói hàng số ${details[i - 1].FK_Id_ContentPack}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table">
                        <thead class="table-light">
                          <tr>
                            <th class="py-3" scope="col">Tổng số lượng trong kho</th>
                            <th class="py-3" scope="col">Đơn giá gói hàng</th>
                            <th class="py-3" scope="col">Xem chi tiết</th>
                          </tr>
                        </thead>
                        <tbody class="table-packs" class="p-5"
                            data-value="${details[i - 1].FK_Id_ContentPack}">
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer" style="height: 100px">
                      <div class="d-flex align-items-stretch justify-content-between w-100">
                          <div class="input-group w-50">
                            <label class="input-group-text" for="Count">Số lượng</label>
                            <input type="number" name="Count" id="Count" class="form-control">
                          </div>
                          <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary btnTake" data-id="${details[i - 1].FK_Id_ContentPack}">Lấy gói hàng</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>`
              $('#cell' + i).append(modals);
            }
          }
        }
      }
    });

    function showToast(message, bgColorClass, iconClass) {
      $(".toast-body").addClass(bgColorClass);
      $("#icon").addClass(iconClass);
      $("#toast-msg").html(message);
      setTimeout(() => {
        $(".toast-body").removeClass(bgColorClass);
        $("#icon").removeClass(iconClass);
      }, 5000);
      toastBootstrap.show();
    }
    $(document).on("click", ".btnTake", function () {
      let id = $(this).data("id");
      let token = $('meta[name="csrf-token"]').attr("content");
      let modalElement = $("#show-" + id); // Lấy modal tương ứng với hàng
      let SimpleOrPack = 1;
      $.ajax({
        url: "/orders/checkCustomer",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          SimpleOrPack: SimpleOrPack,
          _token: token,
        },
        success: function (response) {
          console.log(response);
          if (response.flag == 1) {
            let soLuongLay = modalElement.find("input[name='Count']").val().trim();
            let soLuongTon = modalElement.find("td[data-id='SoLuong']").data("value");
            if (soLuongLay === "") {
              showToast("Chưa nhập số lượng cần lấy", "bg-warning", "fa-xmark-circle");
            } else if (soLuongTon === 0) {
              showToast("Kho đã hết gói hàng", "bg-danger", "fa-xmark-circle");
            } else {
              let pack = $("tbody").find("#pack-" + id);
              let cell = pack.closest("td");
              cell.attr('data-value', soLuongLay);
              if (soLuongLay > soLuongTon) {
                showToast("Số lượng lấy không được lớn hơn số lượng tồn", "bg-danger", "fa-xmark-circle");
              } else {
                cell.css("background-color", "#28a475").attr("isTake", true);
                showToast("Lấy gói hàng thành công", "bg-success", "fa-check-circle");
                modalElement.modal("hide");
              }
            }
          } else {
            showToast("Lấy gói hàng thất bại", "bg-danger", "fa-xmark-circle");
            modalElement.modal("hide");
          }
        },
        error: function (xhr) {
          console.log(xhr);
        },
      });
    });
    $(document).on("click", ".btnShow", function () {
      let id = $(this).data("id");
      $.ajax({
        url: "{{ route('wares.showPack') }}",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          _token: token,
        },
        success: function (response) {
          let table;
          $(".table-packs").each(function () {
            if ($(this).data("value") == id) {
              table = $(this);
            }
          });
          let htmls = "";
          let data = response;
          htmls += `<tr>
                      <td class="text-center" data-id="SoLuong" data-value="${data.SoLuong}">${data.SoLuong}</td>
                      <td class="text-center">${numberFormat(data.Price_Pack)} VNĐ</td>
                      <td class="text-center">
                        <button class="btn btn-sm text-secondary btnDetail" data-bs-target="#showDetails-${data.Id_ContentPack}" 
                        data-id="${data.Id_ContentPack}" data-bs-toggle="modal">
                          <i class="fa-solid fa-eye"></i>
                        </button>
                      </td>
                    </tr>`;
          table.html(htmls);

          let modal = ` 
              <div class="modal fade" id="showDetails-${data.Id_ContentPack}" tabindex="-1"
                    aria-labelledby="#show-${data.Id_ContentPack}Label" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold text-secondary" id="show-${data.Id_ContentPack}Label">
                      Thông tin các thùng hàng của gói hàng số ${data.Id_ContentPack}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="wrapper w-100 overflow-x-auto">
                        <div class="table-responsive">
                          <table class="table">
                            <thead class="table-light">
                              <tr>
                                <th class="py-3" scope="col">Tên nguyên liệu</th>
                                <th class="py-3" scope="col">Số lượng nguyên liệu</th>
                                <th class="py-3" scope="col">Đơn vị</th>
                                <th class="py-3" scope="col">Thùng chứa</th>
                                <th class="py-3" scope="col">Số lượng thùng chứa</th>
                                <th class="py-3" scope="col">Đơn giá</th>
                              </tr>
                            </thead>
                            <tbody id="table-packs-${data.Id_ContentPack}" class="p-5">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="height: 100px">
                      <div class="d-flex align-items-center justify-content-end w-100">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                      data-bs-target="#show-${data.Id_ContentPack}">
                        Quay lại
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>`
          let cell = $("#pack-" + data.Id_ContentPack);
          cell.parent().append(modal);
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    });

    $(document).on("click", ".btnDetail", function () {
      let id = $(this).data("id");
      let table = $(`#table-packs-${id}`)
      $.ajax({
        url: "{{ route('wares.showSimpleInPack') }}",
        type: 'POST',
        data: {
          id: id,
          _token: token,
        },
        success: function (response) {
          htmls = "";
          $.each(response.data, function (key, value) {
            htmls += `<tr>
                        <td class="text-center">${value.Name_RawMaterial}</td>
                        <td class="text-center">${value.Count_RawMaterial}</td>
                        <td class="text-center">${value.Unit}</td>
                        <td class="text-center">${value.Name_ContainerType}</td>
                        <td class="text-center">${value.Count_Container}</td>
                        <td class="text-center">${numberFormat(
              value.Price_Container
            )} VNĐ </td>
                        </tr>`;
          });
          table.html(htmls);
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    });

    $("#saveBtn").on("click", function () {
      let cellElements = $("tbody td")
      let FK_Id_Order = $("input[name='FK_Id_Order']").val();
      let dataArr = [];

      cellElements.each(function () {
        if ($(this).attr("istake")) {
          let id = $(this).find(".small").attr("data-id");
          let Count = $(this).data("value");
          dataArr.push({
            id: id,
            Count: Count
          });
        }
      })
      if (dataArr.length === 0) {
        window.location.href = '/orders/packs/create?id=' + FK_Id_Order;
      } else {
        $.ajax({
          url: "{{ route('orders.packs.getPack') }}",
          method: "POST",
          dataType: "json",
          contentType: 'application/json', // Thêm dòng này để xác định loại dữ liệu gửi đi là JSON
          data: JSON.stringify({
            dataArr: dataArr,
            FK_Id_Order: FK_Id_Order,
            _token: token,
          }),
          success: function (response) {
            // Lấy URL từ phản hồi JSON
            var redirectUrl = response.url;

            // Chuyển hướng đến route "orders.simples.create"
            window.location.href = redirectUrl + '?id=' + response.id;
          },
          error: function (xhr) {
            // Xử lý lỗi khi gửi yêu cầu Ajax
            console.log(xhr.responseText);
            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
          },
        });
      }
    })
  });
</script>
@endpush