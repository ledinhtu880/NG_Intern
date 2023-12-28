$(document).ready(function () {
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    selectElement.on("change", function () {
        let token = $('meta[name="csrf-token"]').attr("content");
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
        let token = $('meta[name="csrf-token"]').attr("content");
        let form = $("#formInformation");
        let formData = form.serialize();
        let url = "/orders/update";
        let id = $('input[name="Id_Order"').val();
        $.ajax({
            url: url,
            type: "post",
            data: {
                formData: formData,
                _token: token,
                id: id,
            },
            success: function (response) {
                let secondUrl = "/orders/simples/update";
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
                    rowData.Count_Container = row
                        .find("#Count_Container")
                        .val();
                    rowData.Status = row
                        .find("td[data-id='Status']")
                        .data("value");
                    rowData.Price_Container = row
                        .find("#Price_Container")
                        .val();
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
                        window.location.href = "/orders/simples";
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
                    rowElement.remove();
                });

                // Đóng modal
                modalElement.modal("hide");
            },
        });
    });
});
