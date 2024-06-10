const toastLiveExample = $("#liveToast");
const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
function validateInput(element, message) {
    $(element).on("blur", function () {
        if ($(this).val() == "") {
            $(this).addClass("is-invalid");
            $(this).next().show();
            if ($(this).attr("id") == "Note") {
                $(this).next().text(message);
                $(this).next().show();
            } else {
                $(this).closest(".input-group").next().text(message);
                $(this).closest(".input-group").next().show();
            }
        } else {
            if ($(this).attr("id") == "Note") {
                $(this).next().hide();
            } else {
                $(this).closest(".input-group").next().hide();
            }
            $(this).closest(".input-group").next().hide();
            $(this).removeClass("is-invalid");
        }
    });
}

function showToast(message, bgColorClass, iconClass) {
    $(".toast-body").data("bg-color-class", bgColorClass);
    $("#icon").data("icon-class", iconClass);

    $(".toast-body").addClass(bgColorClass);
    $("#icon").addClass(iconClass);
    $("#toast-msg").html(message);
    toastBootstrap.show();
}

$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    let count = $("input[name='count']").val();
    let dateOrderControl = $("input[name='Date_Order']");
    let deliveryDateControl = $("input[name='Date_Delivery']");
    let receptionDateControl = $("input[name='Date_Reception']");
    let isCreate = false;

    validateInput("#Note", "Mô tả không được để trống");
    validateInput(
        "#Count_RawMaterial",
        "Số lượng nguyên vật liệu không được để trống"
    );
    validateInput(
        "#Count_Container",
        "Số lượng thùng chứa không được để trống"
    );
    validateInput("#Price_Container", "Đơn giá không được để trống");

    toastLiveExample.on("hidden.bs.toast", function () {
        var bgColorClass = $(".toast-body").data("bg-color-class");
        var iconClass = $("#icon").data("icon-class");

        $(".toast-body").removeClass(bgColorClass);
        $("#icon").removeClass(iconClass);

        $("#toast-msg").html("");
    });

    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
        let token = $('meta[name="csrf-token"]').attr("content");
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');
        let isTake = rowElement.find('td[data-id="Status"]').data("value");

        // Xóa hàng khi modal được ẩn
        $.ajax({
            url: "/orders/simples/deleteSimple",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                isTake: isTake,
                _token: token,
            },
            success: function (data) {
                modalElement.on("hidden.bs.modal", function () {
                    showToast(
                        "Xóa thùng hàng thành công",
                        "bg-success",
                        "fa-check-circle"
                    );
                    rowElement.remove();
                });

                modalElement.modal("hide");
            },
        });
    });

    var isSaveBtnClicked = false;
    $("#saveBtn").on("click", function (ev) {
        isSaveBtnClicked = true;
        let isValid = true;
        ev.preventDefault();
        $("#formInformation")
            .find(".form-control")
            .each(function () {
                if ($(this).hasClass("is-invalid")) {
                    isValid = false;
                } else if ($(this).val() == "") {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    $(this).next().text("Trường này là bắt buộc");
                    $(this).next().show();
                }
            });

        if (isValid) {
            let rowElement = $("#table-data tr");
            if (rowElement.length > 0) {
                $.ajax({
                    url: "/orders/simples/updateSimple",
                    type: "post",
                    data: {
                        formData: $("#formInformation").serialize(),
                        _token: token,
                    },
                    success: function (response) {
                        $.ajax({
                            type: "POST",
                            url: "/orders/simples/redirectSimples",
                            data: {
                                _token: token,
                            }, // Thêm dữ liệu cần thiết
                            success: function (response) {
                                window.location.href = response.url;
                            },
                            error: function (error) {
                                // Xử lý lỗi khi gửi yêu cầu
                                console.error("Ajax request failed:", error);
                            },
                        });
                    },
                    error: function (xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            } else {
                showToast(
                    "Bạn chưa thêm thùng hàng nào",
                    "bg-warning",
                    "fa-exclamation-circle"
                );
            }
        }
    });

    $("#backBtn").on("click", function () {
        if (count > 0) {
            $.ajax({
                url: "/orders/simples/destroySimplesWhenBack",
                method: "POST",
                dataType: "json",
                data: {
                    _token: token,
                },
                success: function (response) {
                    window.location.href = "/orders/simples/";
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        } else {
            window.location.href = "/orders/simples/";
        }
    });

    toastLiveExample.on("hidden.bs.toast", function () {
        // Lấy giá trị của thuộc tính data-bg-color-class và data-icon-class
        var bgColorClass = $(".toast-body").data("bg-color-class");
        var iconClass = $("#icon").data("icon-class");

        // Xóa các lớp CSS từ toast
        $(".toast-body").removeClass(bgColorClass);
        $("#icon").removeClass(iconClass);

        // Xóa nội dung của toast
        $("#toast-msg").html("");
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
        let isValid = true;

        if (isProcessing || clickCount >= 1) {
            return;
        }
        isProcessing = true;
        clickCount++;

        $("#formInformation")
            .find(".form-control")
            .each(function () {
                if ($(this).hasClass("is-invalid")) {
                    isValid = false;
                } else if ($(this).val() == "") {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    $(this).next().text("Trường này là bắt buộc");
                    $(this).next().show();
                }
            });

        if (isValid) {
            if (count == 0) {
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
                            "/orders/simples/getSimplesInWarehouse?id=" +
                            response.id;
                    },
                    error: function (xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                    complete: function () {
                        isProcessing = false;
                        clickCount = 0;
                    },
                });
            } else if (count == 1) {
                let id = $("#Id_Order").val();
                window.location.href =
                    "/orders/simples/getSimplesInWarehouse?id=" + id;
            }
        } else {
            isProcessing = false;
            clickCount = 0; // Đặt lại clickCount nếu có lỗi trong dữ liệu đầu vào
        }
    });
    $("#formProduct").on("submit", function (event) {
        isCreate = true;
        let isValid = true;
        event.preventDefault();

        $("#formInformation .form-control").each(function () {
            if ($(this).hasClass("is-invalid")) {
                isValid = false;
            } else if ($(this).val() == "") {
                $(this).addClass("is-invalid");
                $(this).next().text("Trường này là bắt buộc");
                $(this).next().show();
                isValid = false;
            }
        });

        if (isValid) {
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
                    success: function (response) {},
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
                    $("#Id_Order").val(id);

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
        }
    });

    $(".sidebar-wrapped, .breadcrumb")
        .find("a")
        .click(function (event) {
            if (count > 0) {
                $.ajax({
                    url: "/orders/simples/destroySimplesWhenBack",
                    method: "POST",
                    dataType: "json",
                    data: {
                        _token: token,
                    },
                    success: function (response) {
                        window.location.href = "/orders/simples/";
                    },
                    error: function (xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            }
        });
});
