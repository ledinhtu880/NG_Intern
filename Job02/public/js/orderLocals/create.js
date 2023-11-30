$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    let selectElement = $("#FK_Id_CustomerType");
    let firstOptionValue = $(selectElement).val();
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
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);

        return parts.join(decimalSeparator);
    }

    // Hàm chuyển đổi định dạng ngày tháng thành "dd/mm/yyyy"
    function formatDate(date) {
        const d = new Date(date);
        const day = String(d.getDate()).padStart(2, "0");
        const month = String(d.getMonth() + 1).padStart(2, "0");
        const year = d.getFullYear();
        return `${day}/${month}/${year}`;
    }
    selectElement.on("change", function () {
        let id = $(this).val();
        let SimpleOrPack = $("#SimpleOrPack").val();
        let firstUrl = "/orderLocals/showSimple";
        $("#table-data").empty();
        $("#table-result").empty();
        $.ajax({
            url: firstUrl,
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                SimpleOrPack: SimpleOrPack,
                _token: token,
            },
            success: function (response) {
                let dataHtmls = "";
                let secondUrl = "/orderLocals/showOrder";
                $.each(response.data, function (key, value) {
                    dataHtmls += `<tr>
                        <td class="d-flex justify-content-center" data-id="Id_SimpleContent"
                            data-value="${value.Id_SimpleContent}">
                            <input type="checkbox" class="checkbox form-check-input" name="firstFormCheck"
                            id="firstFormCheck-${value.Id_SimpleContent}">
                        </td>
                        <td data-id="Name_Customer" data-value="${
                            value.Name_Customer
                        }" class="text-center text-truncate"
                            style="max-width: 200px; width: 200px;">
                            ${value.Name_Customer}
                        </td>
                        <td data-id="Name_RawMaterial" data-value="${
                            value.Name_RawMaterial
                        }" class="text-center">
                        ${value.Name_RawMaterial}
                        </td>
                        <td data-id="Count_RawMaterial" data-value="${
                            value.Count_RawMaterial
                        }" class="text-center">
                        ${value.Count_RawMaterial}
                        </td>
                        <td data-id="Name_ContainerType" data-value="${
                            value.Name_ContainerType
                        }" class="text-center">
                        ${value.Name_ContainerType}
                        </td>
                        <td data-id="Count_Container" data-value="${
                            value.Count_Container
                        }" class="text-center">
                        ${value.Count_Container}
                        </td>
                        <td data-id="Price_Container" data-value="${
                            value.Price_Container
                        }" class="text-center">
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
                        _token: token,
                    },
                    success: function (response) {
                        let resultHtmls = "";
                        $.each(response.orders, function (key, value) {
                            resultHtmls += `
                                <tr>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center">
                                    <input type="checkbox" class="checkbox form-check-input" name="secondFormCheck"
                                        id="secondFormCheck-${
                                            value.Id_OrderLocal
                                        }">
                                    </div>
                                </td>
                                <td data-id="Id_OrderLocal" data-value="${
                                    value.Id_OrderLocal
                                }"
                                    class="text-center">
                                    ${value.Id_OrderLocal}
                                </td>
                                <td class="text-center">
                                    ${value.Count}
                                </td>
                                <td class="text-center">
                                    ${
                                        value.SimpleOrPack == 1
                                            ? "Gói hàng"
                                            : "Thùng hàng"
                                    }
                                </td>
                                <td class="text-center">
                                    ${formatDate(value.DateDilivery)}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btnShow btn btn-sm btn-outline-light
                                    text-primary-color border-secondary" data-bs-toggle="modal"
                                    data-bs-target="#show-${
                                        value.Id_OrderLocal
                                    }"
                                    data-id="${value.Id_OrderLocal}">
                                    <i class="fa-solid fa-eye"></i>
                                    </button>
    
                                    <div class="modal fade" id="show-${
                                        value.Id_OrderLocal
                                    }" tabindex="-1"
                                    aria-labelledby="#show-${
                                        value.Id_OrderLocal
                                    }Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                                            <h5 class="modal-title w-100 " id="show-${
                                                value.Id_OrderLocal
                                            }Label">
                                            Thông tin chi tiết đơn hàng số ${
                                                value.Id_OrderLocal
                                            }
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
                                            <tbody class="table-simples" class="p-5"
                                                data-value="${
                                                    value.Id_OrderLocal
                                                }">
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
        let dateDeliveryInput = $("input[name='DateDilivery']");
        let dateDeliveryInputValue = dateDeliveryInput.val();
        let SimpleOrPack = $("#SimpleOrPack").val();
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
            let url = "/orderLocals/store";
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
                    let DateDilivery = newData.DateDilivery;

                    // Tạo chuỗi HTML cho dữ liệu mới
                    let html = `
                    <tr>
                        <td class="align-middle">
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="checkbox" class="checkbox form-check-input" name="secondFormCheck" id="secondFormCheck-${Id_OrderLocal}">
                        </div>
                        </td>
                        <td data-id="Id_OrderLocal" data-value="${Id_OrderLocal}" class="text-center">${Id_OrderLocal}</td>
                        <td class="text-center">${Count}</td>
                        <td class="text-center">${
                            newData.SimpleOrPack == 1
                                ? "Gói hàng"
                                : "Thùng hàng"
                        }</td>
                        <td class="text-center">${formatDate(DateDilivery)}</td>
                        <td class="text-center">
                            <button type="button" class="btnShow btn btn-sm btn-outline-light
                                text-primary-color border-secondary" data-bs-toggle="modal"
                                data-bs-target="#show-${Id_OrderLocal}"
                                data-id="${Id_OrderLocal}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
    
                            <div class="modal fade" id="show-${Id_OrderLocal}" tabindex="-1"
                                aria-labelledby="show-${Id_OrderLocal}Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                                        <h5 class="modal-title w-100 " id="exampleModalLabel">
                                            Thông tin chi tiết đơn hàng số ${Id_OrderLocal}
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

                    // Các tác vụ khác sau khi hiển thị thành công
                    $(".toast-body").addClass("bg-success");
                    $("#icon").addClass("fa-check-circle");
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
            $("#toast-msg").html("Vui lòng chọn đơn sản xuất");
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
                rowData.Id_OrderLocal = $(this)
                    .find('td[data-id="Id_OrderLocal"]')
                    .data("value");
                rowDataArray.push(rowData);
                isValid = true;
            }
        });
        if (isValid) {
            let url = "/orderLocals/destroyOrder";
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

    $(document).on("click", ".btnShow", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "/orderLocals/showDetail",
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
    $("#SimpleOrPack").on("change", function () {
        $(selectElement).change();
    });
});
