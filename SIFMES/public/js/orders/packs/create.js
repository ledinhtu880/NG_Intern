$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    let dateOrderControl = $("input[name='Date_Order']");
    let deliveryDateControl = $("input[name='Date_Delivery']");
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

    let count = $("input[name='count']").val();
    $("#addBtn").on("click", function () {
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
                    window.location.href =
                        "/orders/packs/createSimpleToPack?id=" + response.id;
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
            window.location.href = "/orders/packs/createSimpleToPack?id=" + id;
        }
    });
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
                    window.location.href =
                        "/orders/packs/getPacksInWarehouse?id=" + response.id;
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
            window.location.href = "/orders/packs/getPacksInWarehouse?id=" + id;
        }
    });
});
