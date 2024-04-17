const toastLiveExample = $("#liveToast");
const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

$(document).ready(function () {
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

  let token = $('meta[name="csrf-token"]').attr("content");
  let count = $("input[name='count']").val();
  let dateOrderControl = $("input[name='Date_Order']");
  let deliveryDateControl = $("input[name='Date_Delivery']");
  let receptionDateControl = $("input[name='Date_Reception']");
  dateOrderControl.on("change", function () {
    let selectedDate = new Date($(this).val());
    let currentDate = new Date();
    let formMessage = $(this).parent().next();
    if (selectedDate > currentDate) {
      formMessage.html("Vui lòng chọn ngày phù hợp");
      $(this).addClass("is-invalid");
    } else {
      formMessage.html("");
      $(this).removeClass("is-invalid");
    }
  });
  validateDate(deliveryDateControl, dateOrderControl);
  validateDate(receptionDateControl, dateOrderControl);
  validateDate(receptionDateControl, deliveryDateControl);

  let isProcessing = false;
  let clickCount = 0;
  $("#redirectBtn").on("click", function () {
    if (isProcessing || clickCount >= 1) {
      return;
    }
    isProcessing = true;
    clickCount++;

    // Thực hiện yêu cầu Ajax
    $.ajax({
      url: "/orders/store",
      type: "post",
      data: {
        formData: $("#formInformation").serialize(),
        _token: token,
      },
      success: function (response) {
        // Xử lý thành công
        window.location.href =
          "/orders/simples/getSimplesInWarehouse?id=" + response.id;
      },
      error: function (xhr) {
        // Xử lý lỗi khi gửi yêu cầu Ajax
        console.log(xhr.responseText);
        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
      },
      complete: function () {
        isProcessing = false;
      },
    });
  });
  $("#formProduct").on("submit", function (event) {
    event.preventDefault();
    let form = $(this);
    let unit = $("p[data-name='unit']").html();
    if (count == 0) {
      count++;
      $.ajax({
        url: "/orders/store",
        type: "post",
        data: {
          formData: $("#formInformation").serialize(),
          _token: token,
        },
        success: function (response) { },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    }
    $.ajax({
      url: "/orders/simples/addSimple",
      type: "post",
      data: {
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
                        <td class="text-center" data-id="rawMaterialId" data-value="${rawMaterialId}">
                            ${rawMaterialName}
                        </td>
                        <td class="text-center" data-id="Count_RawMaterial" data-value="${value.Count_RawMaterial}">
                            ${value.Count_RawMaterial}
                        </td>
                        <td class="text-center">${value.unit}</td>
                        <td class="text-center" data-id="containerTypeId" data-value="${containerTypeId}">
                            ${containerTypeName}
                        </td>
                        <td class="text-center" data-id="Count_Container" data-value="${value.Count_Container}">
                            ${value.Count_Container}
                        </td>
                        <td class="text-center">
                            Sản xuất mới
                        </td>
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${value.formattedPrice}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#deleteID-${id}">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="modal fade" id="deleteID-${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p class="m-0">Bạn chắc chắn muốn xóa thùng hàng này?</p>

                                  <p class="m-0">
                                      Việc này sẽ xóa thùng hàng vĩnh viễn. <br>
                                      Hãy chắc chắn trước khi tiếp tục.
                                  </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-danger btnDelete" data-id="${id}">Xác nhận</button>
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
          let existingRow = $(
            `#table-data tr[data-id="${response.existsData.Id_ContentSimple}"]`
          );
          existingRow
            .find('[data-id="Count_RawMaterial"]')
            .text(response.existsData.Count_RawMaterial);
          existingRow
            .find('[data-id="Count_Container"]')
            .text(response.existsData.Count_Container);
          existingRow
            .find('[data-id="Price_Container"]')
            .text(response.existsData.formattedPrice);
        }
        showToast(
          "Thêm thùng hàng thành công",
          "bg-success",
          "fa-check-circle"
        );
      },
    });
  });
});
