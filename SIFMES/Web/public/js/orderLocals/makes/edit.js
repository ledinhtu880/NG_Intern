$(document).ready(function () {
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

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

    $("#updateBtn").on("click", function () {
        if ($("#Count").val() <= 0) {
            showToast(
                "Số lượng phải lớn hơn 0",
                "bg-warning",
                "fa-exclamation-circle"
            );
        } else {
            $("#formInformation").submit();
        }
    });

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
    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
        let token = $('meta[name="csrf-token"]').attr("content");
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');

        // Xóa hàng khi modal được ẩn
        $.ajax({
            url: "/orderLocals/makes/destroySimple",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                _token: token,
            },
            success: function (response) {
                modalElement.on("hidden.bs.modal", function () {
                    showToast(
                        "Xóa thùng hàng thành công",
                        "bg-success",
                        "fa-check-circle"
                    );
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
                rowData.Id_ContentSimple = $(this)
                    .find('td[data-id="Id_ContentSimple"]')
                    .data("value");
                rowDataArray.push(rowData);
                isValid = true;
            }
        });
        if (isValid) {
            let url = "/orderLocals/makes/storeSimple";
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
            showToast(
                "Vui lòng chọn đơn sản xuất",
                "bg-warning",
                "fa-exclamation-circle"
            );
        }
    });
});
