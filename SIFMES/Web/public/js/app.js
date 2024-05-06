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

function validateInput(element, message) {
    $(element).on('blur', function() {
        if ($(this).val() == "") {
            $(this).next().show();
            $(this).addClass("is-invalid");
            $(this).next().text(message);
        } else {
            $(this).next().hide();
            $(this).removeClass("is-invalid");
        }
    });
}

$(document).on('keydown', function(e) {
    // Kiểm tra xem phím được ấn có phải là tab không
    if (e.keyCode === 9) {
        // Ngăn chặn hành động mặc định của tab
        e.preventDefault();
    
        // Lấy tất cả các phần tử có thuộc tính tabIndex
        var tabbableElements = $('[tabIndex]').filter(function() {
            return $(this).attr('tabIndex') !== '-1';
        });
    
        tabbableElements = tabbableElements.sort(function(a, b) {
            return a.getAttribute("tabindex") - b.getAttribute("tabindex");
        });
    
        // Lấy chỉ số của phần tử đang được focus
        var currentIndex = tabbableElements.index(document.activeElement);
    
        // Tìm phần tử tiếp theo có thể được tab đến
        var nextIndex = currentIndex + 1;
        if (nextIndex >= tabbableElements.length) {
            // Nếu đã ở cuối danh sách, quay lại với phần tử đầu tiên
            nextIndex = 0;
        }
    
        // Di chuyển focus đến phần tử tiếp theo có thể được tab đến
        var nextElement = tabbableElements[nextIndex];
        nextElement.focus();

        if(nextElement.type == 'number'){
            nextElement.type = 'text';
            nextElement.selectionStart = nextElement.selectionEnd = nextElement.value.length;
            nextElement.type = 'number';
        }
        else{
            // Trỏ đến cuối input bằng cách đặt selectionStart và selectionEnd
            var input = nextElement;
            input.selectionStart = input.selectionEnd = input.value.length;
        }
        
    }
});