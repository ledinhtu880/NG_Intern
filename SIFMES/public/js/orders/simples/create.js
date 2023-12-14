const toastLiveExample = $("#liveToast");
const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    let countID = 0;
    let count = $("input[name='count']").val();
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

    $("#redirectBtn").on("click", function () {
        if (count == 0) {
            let form = $("#formInformation");
            let formData = form.serialize();
            let url = "/orders/store";
            count++;
            $.ajax({
                url: url,
                type: "post",
                data: {
                    formData: formData,
                    _token: token,
                },
                success: function (response) {
                    console.log(response);
                    window.location.href =
                        "/orders/simples/getSimplesInWarehouse?id=" +
                        response.id;
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        } else if (count == 1) {
            let urlParams = new URLSearchParams(window.location.search);
            let id = urlParams.get("id");
            window.location.href =
                "/orders/simples/getSimplesInWarehouse?id=" + id;
        }
    });
    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
        let token = $('meta[name="csrf-token"]').attr("content");
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
    $("#formProduct").on("submit", function (event) {
        event.preventDefault();
        let form = $(this);
        let url = "/orders/simples/addSimple";
        let unit = $("p[data-name='unit']").html();
        let flag = 1;
        if (count == 0) {
            let form = $("#formInformation");
            let formData = form.serialize();
            let url = "/orders/store";
            count++;
            $.ajax({
                url: url,
                type: "post",
                data: {
                    formData: formData,
                    _token: token,
                },
                success: function (response) {},
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        }
        $.ajax({
            url: url,
            type: "post",
            data: {
                unit: unit,
                flag: flag,
                formData: form.serialize(),
                _token: token,
            },
            success: function (response) {
                let htmls = "";
                let id = countID + parseInt(response.maxID);
                countID++;
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
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${value.formattedPrice}
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#deleteRow${id}">
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

                $("#icon").addClass("fa-check-circle");
                $(".toast-body").addClass("bg-success");
                $("#toast-msg").html("Thêm thùng hàng thành công");
                toastBootstrap.show();
            },
        });
    });
});
