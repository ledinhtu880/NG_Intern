function validateInput(element, message = null) {
    $(element).on("blur", function () {
        if ($(this).val() == "") {
            $(this).addClass("is-invalid");
            $(this).next().text(message);
            $(this).next().show();
        } else {
            if ($(this).attr("id") == "Sym_Sub") {
                if (!/^[a-zA-Z0-9,-]+$/.test($(this).val())) {
                    $(this).addClass("is-invalid");
                    $(this).next().text("Vui lòng chỉ nhập ký tự chữ và số.");
                    $(this).next().show();
                } else {
                    $(this).next().hide();
                    $(this).removeClass("is-invalid");
                }
            } else if ($(this).attr("id") == "Les_Name") {
                if (!/^[\w\W\s\d-,]*$/.test($(this).val())) {
                    $(this).addClass("is-invalid");
                    $(this).next().text("Vui lòng chỉ nhập ký tự chữ và số.");
                    $(this).next().show();
                } else {
                    $(this).next().hide();
                    $(this).removeClass("is-invalid");
                }
            } else if (
                $(this).attr("id") == "Theory" ||
                $(this).attr("id") == "Exercise" ||
                $(this).attr("id") == "Practice"
            ) {
                if ($(this).val() < 0) {
                    $(this).addClass("is-invalid");
                    $(this).next().text("Số giờ học phải lớn hơn 0");
                    $(this).next().show();
                } else {
                    $(this).removeClass("is-invalid");
                    $(this).next().hide();
                }
            }
        }
    });
}

function validateInputInModal(element, message = null) {
    $(".modal-edit").on("blur", "input", function () {
        element = $(this);
        if (element.val() == "") {
            element.addClass("is-invalid");
            element.next().text(message);
            element.next().show();
        } else {
            if (
                element.attr("id") == "Les_Name" ||
                element.attr("id") == "Les_Unit"
            ) {
                if (!/^[\w\s\d-,]*$/.test(element.val())) {
                    element.addClass("is-invalid");
                    element.next().text("Vui lòng chỉ nhập ký tự chữ và số.");
                    element.next().show();
                } else {
                    element.next().hide();
                    element.removeClass("is-invalid");
                }
            } else if (
                element.attr("id") == "Theory" ||
                element.attr("id") == "Exercise" ||
                element.attr("id") == "Practice"
            ) {
                if (element.val() < 0) {
                    element.addClass("is-invalid");
                    element.next().text("Số giờ học phải lớn hơn 0");
                    element.next().show();
                } else {
                    element.removeClass("is-invalid");
                    element.next().hide();
                }
            }
        }
    });
}

$(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    const toastElement = $("#toastMessage");
    const toastBs = new bootstrap.Toast(toastElement.get(0));
    toastBootstrap.show();

    function showToast(message, bgColorClass, iconClass) {
        $("#toastMessage .toast-body").data("bg-color-class", bgColorClass);
        $("#toastMessage #icon").data("icon-class", iconClass);

        $("#toastMessage .toast-body").addClass(bgColorClass);
        $("#toastMessage #icon").addClass(iconClass);
        $("#toastMessage #toast-msg").html(message);
        toastBs.show();

        $("#toastMessage").on("hidden.bs.toast", function () {
            setTimeout(function () {
                $("#toastMessage .toast-body").removeClass(bgColorClass);
                $("#toastMessage #icon").removeClass(iconClass);
            }, 100);
        });
    }

    let selectElement = $("#selectSubject");
    $(selectElement).on("change", function () {
        let symSubject = $(this).val();

        $.ajax({
            url: "/lessonSub/showSubjects",
            method: "POST",
            dataType: "json",
            data: {
                symSubject: symSubject,
                _token: token,
            },
            success: function (response) {
                let data = response.data;

                $("#table-data").empty();
                $.each(data, function (key, value) {
                    let editModalID = "editModal-" + response.Id_Sub;
                    let deleteModalId = "deleteModal-" + response.Id_Sub;

                    let htmls = `<tr class="align-middle text-center" data-id="${response.Id_Sub}">
                            <td scope="row" class="fw-bold">${value["Ký hiệu môn học"]}</td>
                            <td data-id="lesUnit" data-value="${value["Bài học"]}">
                                <span class="badge text-bg-secondary fw-medium fs-6">${value["Bài học"]}</span>
                            </td>
                            <td data-id="lesName" data-value="${value["Tên bài học"]}">
                                ${value["Tên bài học"]}
                            </td>
                            <td>${value["Lý thuyết"]}</td>
                            <td>${value["Bài tập"]}</td>
                            <td>${value["Thực hành"]}</td>
                            <td>
                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#${editModalID}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <div class="modal fade" id="${editModalID}" tabindex="-1"
                            aria-labelledby="${editModalID}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="${editModalID}Label">Sửa bài học</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body modal-edit">
                                            <form>
                                                <div class="d-flex gap-2 mb-3">
                                                    <div class="form-group" style="flex: 1; text-align: start;">
                                                        <label for="Sym_Sub" class="form-label">Ký hiệu môn học</label>
                                                        <input type="text" name="Sym_Sub" id="Sym_Sub"
                                                            class="form-control"
                                                            value="${value["Ký hiệu môn học"]}" placeholder="Nhập ký hiệu môn học" readonly>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="form-group" style="flex: 1; text-align: start;">
                                                        <label for="Les_Unit" class="form-label">Bài học</label>
                                                        <input type="text" name="Les_Unit" id="Les_Unit"
                                                            class="form-control"
                                                            value="${value["Bài học"]}" placeholder="Nhập tên bài học">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3" style="text-align: start;">
                                                    <label for="Les_Name" class="form-label">Tiêu đề bài học</label>
                                                    <input type="text" name="Les_Name" id="Les_Name"
                                                        class="form-control"
                                                        value="${value["Tên bài học"]}" placeholder="Nhập tiêu đề bài học">
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="d-flex gap-4">
                                                    <div class="form-group" style="flex: 1; text-align: start;">
                                                        <label for="Theory" class="form-label">Lý thuyết</label>
                                                        <input type="number" name="Theory" id="Theory"
                                                            class="form-control"
                                                            value="${value["Lý thuyết"]}" min="0">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="form-group" style="flex: 1; text-align: start;">
                                                        <label for="Exercise" class="form-label">Bài tập</label>
                                                        <input type="number" name="Exercise" id="Exercise"
                                                            class="form-control"
                                                            value="${value["Bài tập"]}" min="0">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="form-group" style="flex: 1; text-align: start;">
                                                        <label for="Practice" class="form-label">Thực hành</label>
                                                        <input type="number" name="Practice" id="Practice"
                                                            class="form-control"
                                                            value="${value["Thực hành"]}" min="0">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-primary btnUpdate" data-id=${response.Id_Sub}>Lưu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#${deleteModalId}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="modal fade" id="${deleteModalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="m-0">Bạn chắc chắn muốn xóa bài học này?</p>
                                                <p class="m-0">
                                                    Việc này sẽ xóa bài học vĩnh viễn. <br>
                                                    Hãy chắc chắn trước khi tiếp tục.
                                                </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="button" class="btn btn-danger btnDelete" data-id="${response.Id_Sub}">Xác nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                    $("#table-data").append(htmls);

                    let lessonUnitInput = $(editModalID).find("#Les_Unit");
                    let lessonNameInput = $(editModalID).find("#Les_Name");

                    validateInputInModal(
                        lessonUnitInput,
                        "Vui lòng nhập bài học"
                    );
                    validateInputInModal(
                        lessonNameInput,
                        "Vui lòng nhập tiêu đề bài học"
                    );
                });
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });

    var firstOptionValue = $(selectElement).val();

    // Gán giá trị cho phần tử select
    $(selectElement).val(firstOptionValue);

    // Gọi sự kiện change để hiển thị dữ liệu
    $(selectElement).change();

    $("#btnCreate").click(function () {
        let symSubject = $("#selectSubject").val();
        $("#Sym_Sub").val(symSubject);
    });

    $("#createSubjectModel").on("hidden.bs.modal", function () {
        let inputs = $(this).find("input").not('[name="Sym_Sub"]');
        inputs.each(function () {
            // Thực hiện các thao tác với từng input
            if (
                $(this).attr("id") == "Theory" ||
                $(this).attr("id") == "Exercise" ||
                $(this).attr("id") == "Practice"
            ) {
                $(this).val("0");
            } else {
                $(this).val("");
            }
        });
    });

    $("#saveBtn").click(function () {
        let isValid = true;

        $(".form-control").each(function () {
            if ($(this).val() == "") {
                isValid = false;
                $(this).addClass("is-invalid");
                $(this).next().text("Trường này là bắt buộc");
                $(this).next().show();
            } else if ($(this).hasClass("is-invalid")) {
                isValid = false;
            }
        });
        if (isValid) {
            let symSubject = $("#Sym_Sub");
            $.ajax({
                url: "/lessonSub/checkAmount",
                method: "POST",
                dataType: "json",
                data: {
                    symSubject: symSubject.val(),
                    theoryNumHour: $("#Theory").val(),
                    exerciseNumHour: $("#Exercise").val(),
                    practiceNumHour: $("#Practice").val(),
                    _token: token,
                },
                success: function (response) {
                    if (response.flag == false) {
                        showToast(
                            response.message,
                            "bg-warning",
                            "fa-xmark-circle"
                        );
                    } else {
                        let lesUnit = $("#Les_Unit");
                        let lesName = $("#Les_Name");
                        let lessons = [
                            {
                                FK_Id_LS: 1,
                                NumHour: $("#Theory").val(),
                            },
                            {
                                FK_Id_LS: 2,
                                NumHour: $("#Exercise").val(),
                            },
                            {
                                FK_Id_LS: 3,
                                NumHour: $("#Practice").val(),
                            },
                        ];
                        let data = {
                            symSubject: symSubject.val(),
                            lesUnit: lesUnit.val(),
                            lesName: lesName.val(),
                            lessons: lessons,
                        };

                        $.ajax({
                            url: "/lessonSub/store",
                            method: "POST",
                            dataType: "json",
                            data: {
                                data: data,
                                _token: token,
                            },
                            success: function (response) {
                                $("#createSubjectModel").modal("hide");
                                showToast(
                                    "Thêm bài học thành công",
                                    "bg-success",
                                    "fa-check-circle"
                                );
                                $(selectElement).change();
                            },
                            error: function (xhr) {
                                // Xử lý lỗi khi gửi yêu cầu Ajax
                                console.log(xhr.responseText);
                                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                            },
                        });
                    }
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        }
    });

    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let modalElement = $("#deleteModal-" + id); // Lấy modal tương ứng với hàng
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');
        let lesUnit = rowElement.find("td[data-id='lesUnit']").data("value");

        // Xóa hàng khi modal được ẩn
        $.ajax({
            url: "/lessonSub/destroy",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                lesUnit: lesUnit,
                _token: token,
            },
            success: function (response) {
                modalElement.on("hidden.bs.modal", function () {
                    showToast(
                        "Xóa bài học thành công",
                        "bg-success",
                        "fa-check-circle"
                    );
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

    $(document).on("click", ".btnUpdate", function () {
        let id = $(this).data("id");
        let modalElement = $("#editModal-" + id); // Lấy modal tương ứng với hàng
        let data = {};
        data["idSub"] = id;
        data["symSubject"] = modalElement.find("#Sym_Sub").val();
        data["lesUnit"] = modalElement.find("#Les_Unit").val();
        data["lesName"] = modalElement.find("#Les_Name").val();
        data["theory"] = modalElement.find("#Theory").val();
        data["exercise"] = modalElement.find("#Exercise").val();
        data["practice"] = modalElement.find("#Practice").val();

        let isValid = true;
        modalElement.find(".form-control").each(function () {
            if ($(this).val() == "") {
                isValid = false;
                $(this).addClass("is-invalid");
                $(this).next().text("Trường này là bắt buộc");
                $(this).next().show();
            } else if (
                $(this).attr("id") == "Practice" ||
                $(this).attr("id") == "Theory" ||
                $(this).attr("id") == "Exercise"
            ) {
                if ($(this).val() < 0) {
                    isValid = false;
                    $(this).addClass("is-invalid");
                    $(this).next().text("Phải lớn hơn 0");
                    $(this).next().show();
                }
            } else if ($(this).hasClass("is-invalid")) {
                isValid = false;
            }
        });

        if (isValid) {
            let symSubject = modalElement.find("#Sym_Sub");
            $.ajax({
                url: "/lessonSub/checkAmount",
                method: "POST",
                dataType: "json",
                data: {
                    symSubject: symSubject.val(),
                    theoryNumHour: modalElement.find("#Theory").val(),
                    exerciseNumHour: modalElement.find("#Exercise").val(),
                    practiceNumHour: modalElement.find("#Practice").val(),
                    _token: token,
                },
                success: function (response) {
                    if (response.flag == false) {
                        showToast(
                            response.message,
                            "bg-warning",
                            "fa-xmark-circle"
                        );
                    } else {
                        $.ajax({
                            url: "/lessonSub/update",
                            method: "POST",
                            dataType: "json",
                            data: {
                                data: data,
                                _token: token,
                            },
                            success: function (response) {
                                if (response == "success") {
                                    $(selectElement).change();
                                    setTimeout(() => {
                                        modalElement.on(
                                            "hidden.bs.modal",
                                            function () {
                                                showToast(
                                                    "Chỉnh sửa bài học thành công",
                                                    "bg-success",
                                                    "fa-check-circle"
                                                );
                                            }
                                        );
                                        // Đóng modal
                                        modalElement.modal("hide");
                                    }, 2000);
                                }
                            },
                            error: function (xhr) {
                                // Xử lý lỗi khi gửi yêu cầu Ajax
                                console.log(xhr.responseText);
                                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                            },
                        });
                    }
                },
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        }
    });

    let modalElement = $("#createSubjectModel");
    validateInput(modalElement.find("#Les_Unit"), "Vui lòng nhập bài học");
    validateInput(
        modalElement.find("#Les_Name"),
        "Vui lòng nhập tiêu đề bài học"
    );
    validateInput(modalElement.find("#Theory"));
    validateInput(modalElement.find("#Exercise"));
    validateInput(modalElement.find("#Practice"));
});
