$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

    $("#addBtn").on("click", function () {
        let rowElements = $("#table-data tr");
        let rowDataArray = [];
        let dateDeliveryInput = $("input[name='DateDilivery']");
        let dateDeliveryInputValue = dateDeliveryInput.val();
        let isValid = false;
        rowElements.each(function () {
            if ($(this).find("input[type=checkbox]").prop("checked") === true) {
                let rowData = {};
                rowData.Id_SimpleContent = $(this)
                    .find('td[data-id="Id_SimpleContent"]')
                    .data("value");
                rowDataArray.push(rowData);
                isValid = true;
            }
        });
        if (isValid) {
            let url = "/makesOrExpeditions/store";
            $.ajax({
                url: url,
                type: "post",
                data: {
                    rowData: rowDataArray,
                    dateValue: dateDeliveryInputValue,
                    _token: token,
                },
                success: function (response) {
                    // Xử lý dữ liệu thành công
                    let newData = response.data;
                    let Id_OrderMakeOrExpedition = response.id;
                    let Count = newData.Count;
                    let DateDilivery = newData.DateDilivery;

                    // Tạo chuỗi HTML cho dữ liệu mới
                    let html = `
                <tr>
                    <td class="align-middle">
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="form-check" name="secondFormCheck" id="secondFormCheck-${Id_OrderMakeOrExpedition}">
                    </div>
                    </td>
                    <td class="text-center">${Id_OrderMakeOrExpedition}</td>
                    <td class="text-center">${Count}</td>
                    <td class="text-center">
                    <button type="button" class="btnShow btn btn-sm btn-outline-light
                      text-primary-color border-secondary" data-bs-toggle="modal"
                      data-bs-target="#show-${Id_OrderMakeOrExpedition}"
                      data-id="${Id_OrderMakeOrExpedition}">
                      <i class="fa-solid fa-eye"></i>
                    </button>

                    <div class="modal fade" id="show-${Id_OrderMakeOrExpedition}" tabindex="-1"
                      aria-labelledby="show-${Id_OrderMakeOrExpedition}Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                            <h5 class="modal-title w-100 " id="exampleModalLabel">
                              Thông tin chi tiết đơn hàng số ${Id_OrderMakeOrExpedition}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-striped m-0">
                              <thead>
                                <tr>
                                  <th class="text-center" scope="col">Nguyên liệu</th>
                                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                                  <th class="text-center" scope="col">Đơn vị</th>
                                  <th class="text-center" scope="col">Thùng chứa</th>
                                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                                  <th class="text-center" scope="col">Đơn giá</th>
                                </tr>
                              </thead>
                              <tbody class="table-simples" class="p-5" data-value="${Id_OrderMakeOrExpedition}">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                    </td>
                    <td class="text-center">
                    ${formatDate(DateDilivery)}
                    </td>
                </tr>`;
                    // Hàm chuyển đổi định dạng ngày tháng thành "dd/mm/yyyy"
                    function formatDate(date) {
                        const d = new Date(date);
                        const day = String(d.getDate()).padStart(2, "0");
                        const month = String(d.getMonth() + 1).padStart(2, "0");
                        const year = d.getFullYear();
                        return `${day}/${month}/${year}`;
                    }

                    // Thêm dữ liệu mới vào đầu bảng 'table-result'
                    $("#table-result").prepend(html);

                    // Bind click event to the view button for the newly added row
                    bindViewButtonClick(
                        $("#table-result").find(".btnShow").first()
                    );

                    // Các tác vụ khác sau khi hiển thị thành công
                    $("#icon").addClass("fa-check-circle");
                    $(".toast-body").addClass("bg-success");
                    $("#toast-msg").html("Thêm đơn sản xuất thành công");
                    toastBootstrap.show();
                    rowElements.each(function () {
                        rowElements.each(function () {
                            $(this)
                                .find("input[type=checkbox]")
                                .prop("checked", false);
                        });
                    });
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        } else {
            $(".toast-body").addClass("bg-warning");
            $("#icon").addClass("fa-xmark-circle");
            $("#toast-msg").html("Vui lòng chọn đơn thùng hàng");
            toastBootstrap.show();
        }
    });
    $("#deleteBtn").on("click", function () {
        let rowElements = $("#table-result tr");
        let rowDataArray = [];
        let isValid = false;
        rowElements.each(function () {
            if ($(this).find("input[type=checkbox]").prop("checked") === true) {
                let rowData = {};
                rowData.Id_OrderMakeOrExpedition = $(this)
                    .find('td[data-id="Id_OrderMakeOrExpedition"]')
                    .data("value");
                rowDataArray.push(rowData);
                isValid = true;
            }
        });
        if (isValid) {
            let url = "/makesOrExpeditions/destroy";
            $.ajax({
                url: url,
                type: "post",
                data: {
                    rowData: rowDataArray,
                    _token: token,
                },
                success: function (response) {
                    rowElements.each(function () {
                        if (
                            $(this)
                                .find("input[type=checkbox]")
                                .prop("checked") === true
                        ) {
                            $(this).remove();
                        }

                        $(".toast-body").addClass("bg-success");
                        $("#icon").addClass("fa-check-circle");
                        $("#toast-msg").html("Xóa đơn sản xuất thành công");
                        toastBootstrap.show();
                    });
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        } else {
            $(".toast-body").addClass("bg-warning");
            $("#icon").addClass("fa-xmark-circle");
            $("#toast-msg").html("Vui lòng chọn đơn sản xuất");
            toastBootstrap.show();
        }
    });
    bindViewButtonClick($(".btnShow"));
    function bindViewButtonClick(element) {
        element.on("click", function () {
            let id = $(this).data("id");
            $.ajax({
                url: "/makesOrExpeditions/show",
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
                    function numberFormat(
                        number,
                        decimals,
                        decimalSeparator,
                        thousandSeparator
                    ) {
                        decimals = decimals !== undefined ? decimals : 0;
                        decimalSeparator = decimalSeparator || ",";
                        thousandSeparator = thousandSeparator || ".";

                        var parsedNumber = parseFloat(number);
                        var parts = parsedNumber.toFixed(decimals).split(".");
                        parts[0] = parts[0].replace(
                            /\B(?=(\d{3})+(?!\d))/g,
                            thousandSeparator
                        );

                        return parts.join(decimalSeparator);
                    }

                    let htmls = "";
                    $.each(response.data, function (key, value) {
                        htmls += `<tr>
                        <td class="text-center">${value.Name_RawMaterial}</td>
                        <td class="text-center">${value.Count_RawMaterial}</td>
                        <td class="text-center">${value.Name_ContainerType}</td>
                        <td class="text-center">${value.Count_Container}</td>
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
    }
});
