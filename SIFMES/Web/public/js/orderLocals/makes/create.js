$(document).ready(function () {
  let token = $('meta[name="csrf-token"]').attr("content");
  const toastLiveExample = $("#liveToast");
  const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

  toastLiveExample.on('hidden.bs.toast', function () {
    // Lấy giá trị của thuộc tính data-bg-color-class và data-icon-class
    var bgColorClass = $(".toast-body").data("bg-color-class");
    var iconClass = $("#icon").data("icon-class");

    // Xóa các lớp CSS từ toast
    $(".toast-body").removeClass(bgColorClass);
    $("#icon").removeClass(iconClass);

    // Xóa nội dung của toast
    $("#toast-msg").html('');
  });

  function showToast(message, bgColorClass, iconClass) {
    $(".toast-body").data("bg-color-class", bgColorClass);
    $("#icon").data("icon-class", iconClass);

    // Thêm các lớp CSS mới cho toast
    $(".toast-body").addClass(bgColorClass);
    $("#icon").addClass(iconClass);
    $("#toast-msg").html(message);
    toastBootstrap.show();
  }


  let selectElement = $("#FK_Id_CustomerType");
  let firstOptionValue = $(selectElement).val();
  selectElement.on("change", function () {
    let id = $(this).val();
    let SimpleOrPack = $("#SimpleOrPack").val();
    let LiquidOrSolid = $("#LiquidOrSolid").val();
    let firstUrl = "/orderLocals/makes/showSimple";
    $("#table-data").empty();
    $("#table-result").empty();
    $.ajax({
      url: firstUrl,
      method: "POST",
      dataType: "json",
      data: {
        id: id,
        SimpleOrPack: SimpleOrPack,
        LiquidOrSolid: LiquidOrSolid,
        _token: token,
      },
      success: function (response) {
        let dataHtmls = "";
        let secondUrl = "/orderLocals/makes/showOrder";
        $.each(response.data, function (key, value) {
          dataHtmls += `<tr>
                        <td class="text-center align-middle" data-id="Id_ContentSimple"
                            data-value="${value.Id_ContentSimple}">
                            <input type="checkbox" class="checkbox form-check-input" name="firstFormCheck"
                            id="firstFormCheck-${value.Id_ContentSimple}">
                        </td>
                        <td data-id="Name_Customer" data-value="${value.Name_Customer}" class="text-truncate"
                            style="max-width: 200px; width: 200px;">
                            ${value.Name_Customer}
                        </td>
                        <td data-id="Name_RawMaterial" data-value="${value.Name_RawMaterial}">
                        ${value.Name_RawMaterial}
                        </td>
                        <td class="text-center" data-id="Count_RawMaterial" data-value="${value.Count_RawMaterial}">
                        ${value.Count_RawMaterial}
                        </td>
                        <td data-id="Name_ContainerType" data-value="${value.Name_ContainerType}">
                        ${value.Name_ContainerType}
                        </td>
                        <td class="text-center" data-id="Count_Container" data-value="${value.Count_Container}">
                        ${value.Count_Container}
                        </td>
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${numberFormat(value.Price_Container)} VNĐ
                        </td>
                        </tr>`;
        });
        $("#table-data").append(dataHtmls);
        $.ajax({
          url: secondUrl,
          method: "POST",
          dataType: "json",
          data: {
            id: id,
            SimpleOrPack: SimpleOrPack,
            LiquidOrSolid: LiquidOrSolid,
            _token: token,
          },
          success: function (response) {
            let resultHtmls = "";
            $.each(response.orders, function (key, value) {
              resultHtmls += `
                                <tr>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center">
                                    <input type="checkbox" class="checkbox form-check-input" name="secondFormCheck"
                                        id="secondFormCheck-${value.Id_OrderLocal}">
                                    </div>
                                </td>
                                <td class="text-center" data-id="Id_OrderLocal" data-value="${value.Id_OrderLocal}"
                                >
                                    ${value.Id_OrderLocal}
                                </td>
                                <td class="text-center">
                                    ${value.Count} thùng
                                </td>
                                <td>
                                    ${value.SimpleOrPack == 1 ? "Gói hàng" : "Thùng hàng"}
                                </td>
                                <td class="text-center">
                                    ${formatDate(value.Date_Delivery)}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btnShow btn btn-sm text-secondary" data-bs-toggle="modal"
                                    data-bs-target="#show-${value.Id_OrderLocal}"
                                    data-id="${value.Id_OrderLocal}">
                                    <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <div class="modal fade" id="show-${value.Id_OrderLocal}" tabindex="-1"
                                    aria-labelledby="#show-${value.Id_OrderLocal}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title fw-bold text-secondary " id="show-${value.Id_OrderLocal}Label">
                                            Thông tin chi tiết đơn hàng số ${value.Id_OrderLocal}
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                            <thead class="table-light">
                                                <tr>
                                                <th scope="col" class="py-3">Nguyên liệu</th>
                                                <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
                                                <th scope="col" class="py-3">Đơn vị</th>
                                                <th scope="col" class="py-3">Thùng chứa</th>
                                                <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
                                                <th scope="col" class="py-3 text-center">Đơn giá</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-simples" class="p-5"
                                                data-value="${value.Id_OrderLocal}">
                                            </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
                                `;
            });
            $("#table-result").append(resultHtmls);
          },
        });
      },
    });
  });

  // Gán giá trị cho phần tử select
  $(selectElement).val(firstOptionValue);
  // Gọi sự kiện change để hiển thị dữ liệu
  $(selectElement).change();

  $("#addBtn").on("click", function () {
    let rowElements = $("#table-data tr");
    let rowDataArray = [];
    let dateDeliveryInput = $("input[name='Date_Delivery']");
    let dateDeliveryInputValue = dateDeliveryInput.val();
    let SimpleOrPack = $("#SimpleOrPack").val();
    let isValid = false;
    rowElements.each(function () {
      if ($(this).find("input[type=checkbox]").prop("checked") === true) {
        let rowData = {};
        rowData.Id_ContentSimple = $(this)
          .find('td[data-id="Id_ContentSimple"]')
          .data("value");
        rowDataArray.push(rowData);
        isValid = true;
      }
    });
    if (isValid) {
      let url = "/orderLocals/makes/store";
      $.ajax({
        url: url,
        type: "post",
        data: {
          rowData: rowDataArray,
          dateValue: dateDeliveryInputValue,
          SimpleOrPack: SimpleOrPack,
          _token: token,
        },
        success: function (response) {
          // Xử lý dữ liệu thành công
          let newData = response.data;
          let Id_OrderLocal = response.id;
          let Count = newData.Count;
          let Date_Delivery = newData.Date_Delivery;

          // Tạo chuỗi HTML cho dữ liệu mới
          let html = `
                    <tr>
                        <td class="align-middle">
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="checkbox" class="checkbox form-check-input" name="secondFormCheck" id="secondFormCheck-${Id_OrderLocal}">
                        </div>
                        </td>
                        <td data-id="Id_OrderLocal" data-value="${Id_OrderLocal}">${Id_OrderLocal}</td>
                        <td>${Count}</td>
                        <td>${newData.SimpleOrPack == 1 ? "Gói hàng" : "Thùng hàng"}</td>
                        <td>${formatDate(Date_Delivery)}</td>
                        <td>
                            <button type="button" class="btnShow btn btn-sm btn-outline-light
                                text-primary border-secondary" data-bs-toggle="modal"
                                data-bs-target="#show-${Id_OrderLocal}"
                                data-id="${Id_OrderLocal}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <div class="modal fade" id="show-${Id_OrderLocal}" tabindex="-1"
                                aria-labelledby="show-${Id_OrderLocal}Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">
                                            Thông tin chi tiết đơn hàng số ${Id_OrderLocal}
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" class="py-3">Nguyên liệu</th>
                                                        <th scope="col" class="py-3">Số lượng nguyên liệu</th>
                                                        <th scope="col" class="py-3">Đơn vị</th>
                                                        <th scope="col" class="py-3">Thùng chứa</th>
                                                        <th scope="col" class="py-3">Số lượng thùng chứa</th>
                                                        <th scope="col" class="py-3">Đơn giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-simples" class="p-5" data-value="${Id_OrderLocal}">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`;

          // Thêm dữ liệu mới vào đầu bảng 'table-result'
          $("#table-result").prepend(html);

          showToast(
            "Thêm đơn sản xuất thành công",
            "bg-success",
            "fa-check-circle"
          );
          rowElements.each(function () {
            rowElements.each(function () {
              $(this)
                .find("input[type=checkbox]")
                .prop("checked", false);
            });
          });
          $(selectElement).change();
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    } else {
      showToast(
        "Vui lòng chọn đơn sản xuất",
        "bg-warning",
        "fa-exclamation-circle"
      );
    }
  });
  $("#deleteBtn").on("click", function () {
    let rowElements = $("#table-result tr");
    let rowDataArray = [];
    let isValid = false;
    rowElements.each(function () {
      if ($(this).find("input[type=checkbox]").prop("checked") === true) {
        let rowData = {};
        rowData.Id_OrderLocal = $(this)
          .find('td[data-id="Id_OrderLocal"]')
          .data("value");
        rowDataArray.push(rowData);
        isValid = true;
      }
    });
    if (isValid) {
      let url = "/orderLocals/makes/destroyOrderMakes";
      $.ajax({
        url: url,
        type: "post",
        data: {
          rowData: rowDataArray,
          _token: token,
        },
        success: function (response) {
          if (response == true) {
            showToast(
              "Đơn hàng đã được khởi động, không thể xóa",
              "bg-warning",
              "fa-exclamation-circle"
            );
          } else {
            rowElements.each(function () {
              if (
                $(this)
                  .find("input[type=checkbox]")
                  .prop("checked") === true
              ) {
                $(this).remove();
              }

              showToast(
                "Xóa đơn sản xuất thành công",
                "bg-success",
                "fa-check-circle"
              );
            });
          }
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    } else {
      showToast(
        "Vui lòng chọn đơn sản xuất",
        "bg-warning",
        "fa-exclamation-circle"
      );
    }
  });

  $(document).on("click", ".btnShow", function () {
    let id = $(this).data("id");
    $.ajax({
      url: "/orderLocals/makes/showDetail",
      method: "POST",
      dataType: "json",
      data: {
        id: id,
        _token: token,
      },
      success: function (response) {
        let table;
        $(".table-simples").each(function () {
          if ($(this).data("value") == id) {
            table = $(this);
          }
        });
        let htmls = "";
        $.each(response.data, function (key, value) {
          htmls += `<tr>
                        <td>${value.Name_RawMaterial}</td>
                        <td class="text-center">${value.Count_RawMaterial}</td>
                        <td>${value.Unit}</td>
                        <td>${value.Name_ContainerType}</td>
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
  $("#SimpleOrPack").on("change", function () {
    $(selectElement).change();
  });
  $("#LiquidOrSolid").on("change", function () {
    $(selectElement).change();
  });
});
