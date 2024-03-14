function numberFormat(number, decimals, decimalSeparator, thousandSeparator) {
    decimals = decimals !== undefined ? decimals : 0;
    decimalSeparator = decimalSeparator || ",";
    thousandSeparator = thousandSeparator || ".";

    var parsedNumber = parseFloat(number);
    var parts = parsedNumber.toFixed(decimals).split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);

    return parts.join(decimalSeparator);
}

// Hàm chuyển đổi định dạng ngày tháng thành "dd/mm/yyyy"
function formatDate(date) {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, "0");
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
}

function validateDate(firstControl, secondControl) {
    $(firstControl).on("change", function () {
        let firstControlValue = new Date($(this).val());
        let secondControlValue = new Date($(secondControl).val());
        let formMessage = $(this).parent().next();

        if (firstControlValue < secondControlValue) {
            formMessage.html("Vui lòng chọn ngày phù hợp");
            $(this).addClass("is-invalid");
        } else {
            formMessage.html("");
            $(this).removeClass("is-invalid");
        }
    });
}
