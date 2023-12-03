$(document).ready(function () {
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
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
    let countID = 0;
    $("#formProduct").on("submit", function (event) {
        event.preventDefault();
        let token = $('meta[name="csrf-token"]').attr("content");
        let form = $(this);
        let url = "/orders/simples/addSimple";
        let unit = $("p[data-name='unit']").html();
        let flag = 0;
        $.ajax({
            url: url,
            type: "post",
            data: {
                unit: unit,
                flag: flag,
                formData: form.serialize(),
                _token: token,
            },
            success: function (response) {
                let htmls = "";
                let id = countID + parseInt(response.maxID);
                countID++;
                $.each(response.data, function (key, value) {
                    let rawMaterialId = value.FK_Id_RawMaterial;
                    let rawMaterialName = $(
                        `#FK_Id_RawMaterial option[value="${rawMaterialId}"]`
                    ).data("name");
                    let containerTypeId = value.FK_ID_ContainerType;
                    let containerTypeName = $(
                        `#FK_ID_ContainerType option[value="${containerTypeId}"]`
                    ).data("name");
                    htmls += `<tr data-id="${id}">
                        <td class="text-center" data-id="rawMaterialId" data-value="${rawMaterialId}">
                            ${rawMaterialName}
                        </td>
                        <td class="text-center" data-id="Count_RawMaterial" data-value="${value.Count_RawMaterial}">
                            ${value.Count_RawMaterial}
                        </td>
                        <td class="text-center">${value.unit}</td>
                        <td class="text-center" data-id="containerTypeId" data-value="${containerTypeId}">
                            ${containerTypeName}
                        </td>
                        <td class="text-center" data-id="Count_Container" data-value="${value.Count_Container}">
                            ${value.Count_Container}
                        </td>
                        <td class="text-center" data-id="Price_Container" data-value="${value.Price_Container}">
                            ${value.formattedPrice}
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#deleteRow${id}">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="modal fade" id="deleteRow${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn về việc sản phẩm này
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-danger btnDelete" data-id="${id}">Xóa</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        </tr>`;
                });
                $("#table-data").append(htmls);
                // Xóa dữ liệu đã nhập/chọn trong form
                form[0].reset();

                $("#icon").addClass("fa-check-circle");
                $(".toast-body").addClass("bg-success");
                $("#toast-msg").html("Thêm thùng hàng thành công");
                toastBootstrap.show();
            },
        });
    });
    $("#saveBtn").on("click", function () {
        let token = $('meta[name="csrf-token"]').attr("content");
        let url = "/orders/simples/store";
        let order_Id = $("input[name='FK_Id_Order']").val();
        let rowDataArray = [];
        let Price_Pack = 0;
        let idArr = [];
        $("#table-data tr").each(function () {
            let row = $(this);
            let rowData = {};
            var Id_SimpleContent = row.attr("data-id");

            rowData.Id_SimpleContent = Id_SimpleContent;
            rowData.FK_Id_RawMaterial = row
                .find('td[data-id="rawMaterialId"]')
                .data("value");
            rowData.Count_RawMaterial = row
                .find('td[data-id="Count_RawMaterial"]')
                .data("value");
            rowData.FK_Id_ContainerType = row
                .find('td[data-id="containerTypeId"]')
                .data("value");
            rowData.Count_Container = row
                .find('td[data-id="Count_Container"]')
                .data("value");
            rowData.Price_Container = row
                .find('td[data-id="Price_Container"]')
                .data("value");
            rowData.FK_Id_Order = order_Id;
            rowDataArray.push(rowData);
            idArr.push(Id_SimpleContent);

            let subtotal = rowData.Count_Container * rowData.Price_Container; // Tính subtotal
            Price_Pack += subtotal;
        });
        $.ajax({
            url: url,
            type: "post",
            data: {
                rowData: rowDataArray,
                _token: token,
            },
            success: function (response) {
                let countPack = $("input[name='Count_Pack'");
                let countValue = countPack.val();
                let packData = {
                    Count_Pack: countValue,
                    Price_Pack: Price_Pack,
                    FK_Id_Order: order_Id,
                };
                let secondUrl = "/orders/packs/store";
                $.ajax({
                    url: secondUrl,
                    type: "post",
                    data: {
                        packData: packData,
                        _token: token,
                    },
                    success: function (response) {
                        let thirdUrl = "/orders/packs/storeDetail";
                        let Id_PackContent = response.id;
                        $.ajax({
                            url: thirdUrl,
                            type: "post",
                            data: {
                                FK_Id_Order: order_Id,
                                Id_PackContent: Id_PackContent,
                                idArr: idArr,
                                _token: token,
                            },
                            success: function (response) {
                                window.location.href =
                                    "/orders/packs/create?id=" + response.id;
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
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });
    $(document).on("click", ".btnDelete", function () {
        let id = $(this).data("id");
        let rowElement = $(this).closest('tr[data-id="' + id + '"]');
        let modalElement = $("#deleteRow" + id); // Lấy modal tương ứng với hàng
        modalElement.on("hidden.bs.modal", function () {
            // Xóa hàng khi modal được ẩn
            rowElement.remove();
        });
        // Đóng modal
        $("#icon").addClass("fa-check-circle");
        $(".toast-body").addClass("bg-success");
        $("#toast-msg").html("Xóa thùng hàng thành công");
        toastBootstrap.show();
        modalElement.modal("hide");
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
