$(document).ready(function () {
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    let count = 0;

    function validateDate(firstControl, secondControl) {
        $(firstControl).on("change", function () {
            let firstControlValue = new Date($(this).val());
            let secondControlValue = new Date($(secondControl).val());
            let formMessage = $(this).parent().next();

            if (firstControlValue < secondControlValue) {
                formMessage.html("Vui lòng chọn ngày phù hợp");
                $(this).addClass("is-invalid");
            } else {
                formMessage.html("");
                $(this).removeClass("is-invalid");
            }
        });
    }
    $("#formProduct").on("submit", function (event) {
        event.preventDefault();
        let token = $('meta[name="csrf-token"]').attr("content");
        let form = $(this);
        let url = "/simples/addSimple";
        let unit = $("p[data-name='unit']").html();
        $.ajax({
            url: url,
            type: "post",
            data: {
                unit: unit,
                formData: form.serialize(),
                _token: token,
            },
            success: function (response) {
                count++;
                let htmls = "";
                $.each(response.data, function (key, value) {
                    let rawMaterialId = value.FK_Id_RawMaterial;
                    let rawMaterialName = $(
                        `#FK_Id_RawMaterial option[value="${rawMaterialId}"]`
                    ).data("name");
                    let containerTypeId = value.FK_ID_ContainerType;
                    let containerTypeName = $(
                        `#FK_ID_ContainerType option[value="${containerTypeId}"]`
                    ).data("name");
                    htmls += `<tr data-id="${count}">
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
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${value.formattedPrice}
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#deleteRow${count}">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="modal fade" id="deleteRow${count}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <button type="button" class="btn btn-danger btnDelete" data-id="${count}">Xóa</button>
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

                $(".toast-body").addClass("bg-success");
                $("#icon").addClass("fa-check-circle");
                $("#toast-msg").html("Thêm thùng hàng thành công");
                toastBootstrap.show();
            },
        });
    });
    $("#saveBtn").on("click", function () {
        let token = $('meta[name="csrf-token"]').attr("content");
        let form = $("#formInformation");
        let formData = form.serialize();
        let url = "/orders/storeOrder";
        $.ajax({
            url: url,
            type: "post",
            data: {
                formData: formData,
                _token: token,
            },
            success: function (response) {
                let secondUrl = "/simples/storeSimple";
                let rowDataArray = [];
                $("#table-data tr").each(function () {
                    let row = $(this);
                    let rowData = {};
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
                    rowData.FK_Id_Order = response.id;

                    rowDataArray.push(rowData);
                });
                $.ajax({
                    url: secondUrl,
                    type: "post",
                    data: {
                        rowData: rowDataArray,
                        _token: token,
                    },
                    success: function (response) {
                        // Điều hướng về trang chủ
                        window.location.href = "/orders/";
                    },
                    error: function (xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
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
    });
    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');
        let modalElement = $("#deleteRow" + id); // Lấy modal tương ứng với hàng
        modalElement.on("hidden.bs.modal", function () {
            // Xóa hàng khi modal được ẩn
            rowElement.remove();
        });
        $(".toast-body").addClass("bg-success");
        $("#icon").addClass("fa-check-circle");
        $("#toast-msg").html("Xóa thùng hàng thành công");
        toastBootstrap.show();
        // Đóng modal
        modalElement.modal("hide");
    });
    let dateOrderControl = $("input[name='Date_Order']");
    let deliveryDateControl = $("input[name='Date_Dilivery']");
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
});
