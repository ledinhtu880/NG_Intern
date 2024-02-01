$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

    function showToast(message, bgColorClass, iconClass) {
        $(".toast-body").addClass(bgColorClass);
        $("#icon").addClass(iconClass);
        $("#toast-msg").html(message);
        toastBootstrap.show();

        setTimeout(() => {
            toastBootstrap.hide();
            setTimeout(() => {
                $(".toast-body").removeClass(bgColorClass);
                $("#icon").removeClass(iconClass);
                $("#toast-msg").html();
            }, 1000);
        }, 5000);
    }

    selectElement.on("change", function () {
        let id = $(this).val();
        let rowElement = $(this).closest(".js-row");
        $.ajax({
            url: "/rawMaterials/showUnit",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                _token: token,
            },
            success: function (data) {
                let unitElement = rowElement.find("[data-name='unit']");
                unitElement.html(data.unit);
            },
        });
    });
    $("input[name='Count_Container']").on("change", function () {
        let rowElement = $(this).closest(".js-row");
        let price = rowElement.find("#Price_Container").val();
        let totalPrice = parseInt(price) * parseInt($(this).val());

        var formattedPrice = totalPrice.toLocaleString("vi-VN") + " VNĐ";

        rowElement.find("[data-id='total']").html(formattedPrice);
    });
    $("input[name='Price_Container']").on("change", function () {
        let rowElement = $(this).closest(".js-row");
        let count = rowElement.find("#Count_Container").val();
        let totalPrice = parseInt(count) * parseInt($(this).val());

        var formattedPrice = totalPrice.toLocaleString("vi-VN") + " VNĐ";

        rowElement.find("[data-id='total']").html(formattedPrice);
    });
    $("#saveBtn").on("click", function () {
        let form = $("#formInformation");
        let formData = form.serialize();
        let url = "/orders/update";
        let id = $('input[name="Id_Order"').val();
        let modalElement = $("#deleteOrder-" + id); // Lấy modal tương ứng với hàng
        let soLuongThung = $("#Count_Container").val();
        let soLuongNguyenLieu = $("#Count_RawMaterial").val();
        if (soLuongNguyenLieu <= 0 && soLuongThung <= 0) {
            showToast(
                "Số lượng thùng và số lượng nguyên liệu phải lớn hơn 0",
                "bg-warning",
                "fa-exclamation-circle"
            );
            modalElement.modal("hide");
        } else if (soLuongNguyenLieu <= 0) {
            showToast(
                "Số lượng nguyên liệu phải lớn hơn 0",
                "bg-warning",
                "fa-exclamation-circle"
            );
            modalElement.modal("hide");
        } else if (soLuongThung <= 0) {
            showToast(
                "Số lượng thùng phải lớn hơn 0",
                "bg-warning",
                "fa-exclamation-circle"
            );
            modalElement.modal("hide");
        } else {
            let rowDataArray = [];
            $(".js-row").each(function () {
                let row = $(this);
                let rowData = {};
                rowData.Id_ContentSimple = row.data("id");
                rowData.FK_Id_RawMaterial = row
                    .find("#FK_Id_RawMaterial")
                    .val();
                rowData.Count_RawMaterial = row
                    .find("#Count_RawMaterial")
                    .val();
                rowData.FK_Id_ContainerType = row
                    .find("#FK_Id_ContainerType")
                    .val();
                rowData.Count_Container = row.find("#Count_Container").val();
                rowData.Status = row.find("td[data-id='Status']").data("value");
                rowData.Price_Container = row.find("#Price_Container").val();
                rowDataArray.push(rowData);
            });
            if (rowDataArray.length > 0) {
                $.ajax({
                    url: "/wares/checkAmountContentSimple",
                    type: "post",
                    data: {
                        rowData: rowDataArray,
                        id: id,
                        _token: token,
                    },
                    success: function (response) {
                        if (response.flag == true) {
                            showToast(
                                "Số lượng thùng lấy vượt quá số lượng có sẵn trong kho",
                                "bg-warning",
                                "fa-exclamation-circle"
                            );
                        } else {
                            $.ajax({
                                url: url,
                                type: "post",
                                data: {
                                    formData: formData,
                                    SimpleOrPack: 0,
                                    _token: token,
                                    id: id,
                                },
                                success: function (response) {
                                    let secondUrl = "/orders/simples/update";
                                    $.ajax({
                                        url: secondUrl,
                                        type: "post",
                                        data: {
                                            id: id,
                                            rowData: rowDataArray,
                                            _token: token,
                                        },
                                        success: function (response) {
                                            // Điều hướng về trang chủ
                                            window.location.href =
                                                "/orders/simples";
                                        },
                                        error: function (xhr) {
                                            // Xử lý lỗi khi gửi yêu cầu Ajax
                                            console.log(xhr.responseText);
                                            alert(
                                                "Có lỗi xảy ra. Vui lòng thử lại sau."
                                            );
                                        },
                                    });
                                },
                                error: function (xhr) {
                                    // Xử lý lỗi khi gửi yêu cầu Ajax
                                    console.log(xhr.responseText);
                                    alert(
                                        "Có lỗi xảy ra. Vui lòng thử lại sau."
                                    );
                                },
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
                // Điều hướng về trang chủ
                window.location.href = "/orders/simples";
            }
        }
    });
    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');
        let isTake = $(rowElement).find("td[data-id='Status']").data("value");

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
            success: function (response) {
                if (response == true) {
                    modalElement.modal("hide");
                    showToast(
                        "Thùng hàng đã được khởi động, không thể xóa",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    modalElement.on("hidden.bs.modal", function () {
                        rowElement.remove();
                    });

                    // Đóng modal
                    modalElement.modal("hide");
                    showToast(
                        "Xóa thùng hàng thành công",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                }
            },
        });
    });
});
