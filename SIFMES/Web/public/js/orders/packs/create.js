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
                            "/orders/packs/createSimpleToPack?id=" +
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
                let urlParams = new URLSearchParams(window.location.search);
                let id = urlParams.get("id");
                window.location.href =
                    "/orders/packs/createSimpleToPack?id=" + id;
            }
        } else {
            isProcessing = false;
            clickCount = 0; // Đặt lại clickCount nếu có lỗi trong dữ liệu đầu vào
        }
    });

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
                            "/orders/packs/getPacksInWarehouse?id=" +
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
                let urlParams = new URLSearchParams(window.location.search);
                let id = urlParams.get("id");
                window.location.href =
                    "/orders/packs/getPacksInWarehouse?id=" + id;
            }
        } else {
            isProcessing = false;
            clickCount = 0; // Đặt lại clickCount nếu có lỗi trong dữ liệu đầu vào
        }
    });
});
