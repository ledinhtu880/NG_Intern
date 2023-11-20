$(document).ready(function () {
    let selectElement = $('select[name="FK_Id_RawMaterial"]');
    selectElement.on("change", function () {
        let token = $('meta[name="csrf-token"]').attr("content");
        let id = $(this).val();
        $.ajax({
            url: "/rawMaterials/showUnit",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                _token: token,
            },
            success: function (data) {
                let unitElement = $("[data-name='unit']");
                unitElement.html(data.unit);
            },
        });
    });

    let firstOptionValue = $(selectElement).val();
    // Gán giá trị cho phần tử select
    $(selectElement).val(firstOptionValue);
    // Gọi sự kiện change để hiển thị dữ liệu
    $(selectElement).change();
});
