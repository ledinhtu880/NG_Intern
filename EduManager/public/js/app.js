$(document).on("keydown", function (e) {
    // Kiểm tra xem phím được ấn có phải là tab hoặc enter không
    if (
        e.keyCode === 9 ||
        (e.keyCode === 13 && !($(e.target).is("button") || $(e.target).is("a")))
    ) {
        // Ngăn chặn hành động mặc định của tab và enter
        e.preventDefault();

        // Lấy tất cả các phần tử có thuộc tính tabIndex
        var tabbableElements = $("[tabindex]").filter(function () {
            return $(this).attr("tabindex") !== "-1";
        });

        // Sắp xếp các phần tử theo tabIndex
        tabbableElements = tabbableElements.sort(function (a, b) {
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

        if (nextElement.type == "number") {
            nextElement.type = "text";
            nextElement.selectionStart = nextElement.selectionEnd =
                nextElement.value.length;
            nextElement.type = "number";
        } else if (nextElement.type == "text") {
            // Trỏ đến cuối input bằng cách đặt selectionStart và selectionEnd
            var input = nextElement;
            input.selectionStart = input.selectionEnd = input.value.length;
        }
    }
});
