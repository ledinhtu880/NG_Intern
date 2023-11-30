$(document).ready(function () {
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    if ($("input[name='checkFlash']").val() == 1) {
        $(".toast-body").addClass("bg-success");
        $("#icon").addClass("fa-check-circle");
        $("#toast-msg").html("Thêm thùng hàng thành công");
        toastBootstrap.show();

        $("input[name='checkFlash']").val(0);
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
    $("#updateBtn").on("click", function () {
        let form = $("#formInformation");
        let formData = form.serialize();
        let url = "/orderLocals/update";
        let Id_OrderLocal = $('input[name="Id_OrderLocal"').val();
        $.ajax({
            url: url,
            type: "post",
            data: {
                formData: formData,
                _token: token,
                Id_OrderLocal: Id_OrderLocal,
            },
            success: function (response) {
                window.location.href = "/orderLocals/";
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
            url: "/orderLocals/destroySimple",
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

    $("#storeSimpleBtn").on("click", function () {
        let rowElements = $("#table-data tr");
        let rowDataArray = [];
        let isValid = false;
        let id = $("input[name='Id_OrderLocal']").val();
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
            let url = "/orderLocals/storeSimple";
            $.ajax({
                url: url,
                type: "post",
                data: {
                    id: id,
                    rowData: rowDataArray,
                    _token: token,
                },
                success: function (response) {
                    // Lấy URL từ phản hồi JSON
                    var redirectUrl = response.url;

                    // Chuyển hướng đến route "orderLocals.edit"
                    window.location.href = redirectUrl;
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
});
