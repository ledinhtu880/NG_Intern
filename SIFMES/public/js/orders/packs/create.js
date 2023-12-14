$(document).ready(function () {
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

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

    let count = $("input[name='count']").val();
    $("#addBtn").on("click", function () {
        if (count == 0) {
            let token = $('meta[name="csrf-token"]').attr("content");
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
    $(".deletePack").each(function (index, element) {
        $(this).on("click", function () {
            let id = $(this).data("id");
            let urlParams = new URLSearchParams(window.location.search);
            let Id_Order = urlParams.get("id");
            let modalElement = $("#deleteID-" + id); // Lấy modal tương ứng với hàng
            let token = $('meta[name="csrf-token"]').attr("content");
            let rowElement = $(this).closest('tr[data-id="' + id + '"]');

            // Xóa hàng khi modal được ẩn
            $.ajax({
                url: "/orders/packs/deletePacks",
                method: "POST",
                dataType: "json",
                data: {
                    id: id,
                    Id_Order: Id_Order,
                    _token: token,
                },
                success: function (data) {
                    modalElement.on("hidden.bs.modal", function () {
                        rowElement.remove();
                    });

                    // Đóng modal
                    modalElement.modal("hide");
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        });
    });
});
