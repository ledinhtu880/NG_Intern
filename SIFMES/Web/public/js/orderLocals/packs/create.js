$(document).ready(function () {
    const token = $("meta[name='csrf-token']").attr("content");
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

    let slBox_CustomerType = $("#FK_Id_CustomerType");

    slBox_CustomerType.on("change", function () {
        let idCustomerType = $(this).val();
        $.ajax({
            url: "/orderLocals/packs/showSimple",
            data: {
                _token: token,
                idCustomerType: idCustomerType,
            },
            type: "POST",
            success: function (response) {
                $("#table-data").html(response);
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
        $.ajax({
            url: "/orderLocals/packs/showOrderLocal",
            data: {
                _token: token,
                idCustomerType: idCustomerType,
            },
            type: "POST",
            success: function (response) {
                $("#table-result").html(response);
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });

    slBox_CustomerType.change();

    $("#addBtn").on("click", function () {
        let Id_ContentPack = $(".Id_ContentPack");
        let listContentPack = [];
        let Date_Delivery = $("#Date_Delivery").val();
        let checkBoxAdd = $(".checkbox-add");
        for (let i = 0; i < Id_ContentPack.length; i++) {
            if (checkBoxAdd.eq(i).prop("checked")) {
                listContentPack.push(Id_ContentPack.eq(i).html());
            }
        }
        if (listContentPack.length == 0) {
            showToast(
                "Vui lòng chọn ít nhất 1 gói",
                "bg-warning",
                "fa-exclamation-circle"
            );
            return;
        }
        $.ajax({
            url: "/orderLocals/packs/store",
            type: "POST",
            data: {
                _token: token,
                listContentPack: listContentPack,
                Date_Delivery: Date_Delivery,
            },
            success: function (response) {
                $.ajax({
                    url: "/orderLocals/packs/freeContentSimpleInPack",
                    type: "POST",
                    data: {
                        _token: token,
                        listContentPack: listContentPack,
                    },
                    success: function (response) {
                        showToast(
                            "Thêm thành công",
                            "bg-success",
                            "fa-check-circle"
                        );
                        slBox_CustomerType.change();
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

    $("#deleteBtn").on("click", function () {
        let checkRemove = $(".check-remove");
        let Id_OrderLocals = [];
        for (let i = 0; i < checkRemove.length; i++) {
            if (checkRemove.eq(i).prop("checked")) {
                let id_order_local = $(".Id_OrderLocal").eq(i).html();
                Id_OrderLocals.push(id_order_local);
            }
        }
        if (Id_OrderLocals.length == 0) {
            showToast(
                "Vui lòng chọn ít nhất 1 đơn đóng gói",
                "bg-warning",
                "fa-exclamation-circle"
            );
            return;
        }
        $.ajax({
            url: "/orderLocals/packs/delete",
            type: "POST",
            data: {
                _token: token,
                Id_OrderLocals: Id_OrderLocals,
            },
            success: function (response) {
                if (response.flag == true) {
                    showToast(
                        "Đơn hàng đã được khởi động, không thể xóa",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    slBox_CustomerType.change();
                    showToast(
                        "Xóa đơn đóng gói thành công",
                        "bg-success",
                        "fa-check-circle"
                    );
                }
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });
});

$(document).on("click", ".btnShow", function () {
    let id_OrderLocal = $(this).data("id");
    $.ajax({
        url: "/orderLocals/packs/show",
        type: "POST",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            id_OrderLocal: id_OrderLocal,
        },
        success: function (response) {
            $(".table-simples").html(response);
        },
        error: function (xhr) {
            // Xử lý lỗi khi gửi yêu cầu Ajax
            console.log(xhr.responseText);
            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
    });
});
