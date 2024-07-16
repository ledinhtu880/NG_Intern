@extends('layouts.master')

@section('title', 'Danh sách thùng hàng trong kho')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-decoration-none" href="{{ route('orders.simples.index') }}">Quản lý đơn thùng hàng</a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-decoration-none" href="/orders/simples/createSimple?id={{ $_GET['id'] }}">Thêm</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách thùng hàng tại kho 406</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Danh sách thùng hàng tại kho 406
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="h5 fw-bold border-bottom pb-2 m-0">Chi tiết kho chứa</h5>
                    <input type="hidden" name="FK_Id_Order" value="{{ $_GET['id'] }}">
                    <input type="hidden" name="warehouse" value="406">
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table table-bordered border-secondary-subtle">
                            <tr class="d-none">
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                                <td class="square-cell">1</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <a class="btn btn-secondary" href="/orders/simples/createSimple?id={{ $_GET['id'] }}">Quay lại</a>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center justify-content-between">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <i id="icon" class="fas text-light fs-5"></i>
                    <h6 id="toast-msg" class="h6 text-white m-0"></h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            let token = $('meta[name="csrf-token"]').attr("content");
            let ware = $("input[name='warehouse']").val();
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

            toastLiveExample.on('hidden.bs.toast', function() {
                var bgColorClass = $(".toast-body").data("bg-color-class");
                var iconClass = $("#icon").data("icon-class");

                $(".toast-body").removeClass(bgColorClass);
                $("#icon").removeClass(iconClass);

                $("#toast-msg").html('');
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

            $.ajax({
                url: "{{ route('wares.showDetails') }}",
                method: 'POST',
                data: {
                    ware: ware,
                    _token: token,
                },
                success: function(response) {
                    if (response == 0) {
                        $('#rowNumber').val("");
                        $('#colNumber').val("");
                    } else {
                        var details = response.details;
                        var col = response.col;
                        var row = response.row;

                        $('#rowNumber').val(row);
                        $('#colNumber').val(col);
                        var count = 0;
                        for (var i = 1; i <= row; i++) {

                            var newRow = $('<tr></tr>');
                            for (var j = 1; j <= col; j++) {
                                count++;
                                var newCol = $('<td class="position-relative"></td>');
                                newCol.addClass("square-cell");
                                newCol.attr("data-col", +j);
                                newCol.attr("data-row", +i);
                                newCol.attr("id", "cell" + count)
                                var info = $(
                                    '<p class="text-end position-absolute top-0 end-0 p-0 bg-transparent" style="font-size: 0.75rem"></p>'
                                );
                                info.text(i + '.' + j);
                                newCol.append(info);
                                newRow.append(newCol);
                            }

                            $('.table').append(newRow);
                        }
                        for (var i = 1; i <= col * row; i++) {
                            if (details[i - 1].FK_Id_StateCell == "0") {
                                $('#cell' + i).css("background-color", "#d9d3c4");
                                $('#cell' + i).attr("data-status", 0)
                                $('#cell' + i).append($(
                                    '<p class="small">Không thể sử dụng</p>'))
                            } else if (details[i - 1].FK_Id_StateCell == "1") {
                                $('#cell' + i).css("background-color", "#ffffff");
                                $('#cell' + i).attr("data-status", 1);
                                $('#cell' + i).append($('<p class="small">Trống</p>'))
                            } else if (details[i - 1].FK_Id_StateCell == "2") {
                                $('#cell' + i).css("background-color", "#A6BFF7");
                                $('#cell' + i).attr("data-status", 0);
                                $('#cell' + i).append(
                                    $(`<p class="small text-truncate" data-id="${details[i - 1].FK_Id_ContentSimple}"
                                        id="simple-${details[i - 1].FK_Id_ContentSimple}">Thùng hàng <br> số ${details[i - 1].FK_Id_ContentSimple} <br>
                                        <button type="button" class="btnShow btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#show-${details[i - 1].FK_Id_ContentSimple}"
                                        data-id="${details[i - 1].FK_Id_ContentSimple}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button> </p>`));
                                let modals = `
                                <div class="modal fade" id="show-${details[i - 1].FK_Id_ContentSimple}" tabindex="-1"
                                        aria-labelledby="#show-${details[i - 1].FK_Id_ContentSimple}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="show-${details[i - 1].FK_Id_ContentSimple}Label">
                                        Thông tin chi tiết thùng hàng số ${details[i - 1].FK_Id_ContentSimple}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="wrapper w-100 overflow-x-auto">
                                            <div class="table-responsive">
                                            <table class="table table-borderless table-hover m-0">
                                                <thead class="table-heading">
                                                <tr class="align-middle">
                                                    <th scope="col" class="py-2 text-truncate">Nguyên liệu</th>
                                                    <th scope="col" class="py-2 text-truncate" style="width: 200px;">Số lượng nguyên liệu</th>
                                                    <th scope="col" class="py-2 text-truncate">Đơn vị</th>
                                                    <th scope="col" class="py-2 text-truncate">Thùng chứa</th>
                                                    <th scope="col" class="py-2 text-truncate">Tổng số lượng trong kho</th>
                                                    <th scope="col" class="py-2 text-truncate" style="width: 200px;">Số lượng khả dụng</th>
                                                    <th scope="col" class="py-2 text-truncate">Đơn giá</th>
                                                </tr>
                                                </thead>
                                                <tbody class="table-simples" class="p-5"
                                                    data-value="${details[i - 1].FK_Id_ContentSimple}">
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="d-flex align-items-stretch justify-content-between w-100">
                                            <div class="input-group w-50">
                                                <label class="input-group-text" for="Count">Số lượng</label>
                                                <input type="number" name="Count" id="Count" class="form-control">
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn btn-primary btnTake" data-id="${details[i - 1].FK_Id_ContentSimple}">Lấy thùng hàng</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>`
                                $('#cell' + i).append(modals);
                            }
                        }
                    }
                }
            });

            $(document).on("click", ".btnShow", function() {
                let id = $(this).data("id");
                $.ajax({
                    url: "{{ route('wares.showSimple') }}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        let table;
                        $(".table-simples").each(function() {
                            if ($(this).data("value") == id) {
                                table = $(this);
                            }
                        });
                        let htmls = "";
                        $.each(response, function(key, value) {
                            htmls += `<tr class="align-middle">
                                        <td class="text-center">${value.Name_RawMaterial}</td>
                                        <td class="text-center">${value.Count_RawMaterial}</td>
                                        <td class="text-center">${value.Unit}</td>
                                        <td class="text-center">${value.Name_ContainerType}</td>
                                        <td class="text-center">${value.Count_Container}</td>
                                        <td data-id="SoLuong" data-value="${value.SoLuong}" class="text-center">${value.SoLuong}</td>
                                        <td class="text-center">${numberFormat(value.Price_Container)} VNĐ </td>
                                    </tr>`;
                        });
                        table.html(htmls);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });
            $(document).on("click", ".btnTake", function() {
                let id = $(this).data("id");
                let modalElement = $("#show-" + id); // Lấy modal tương ứng với hàng
                let simpleOrPack = 0;
                $.ajax({
                    url: "/orders/checkCustomer",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        simpleOrPack: simpleOrPack,
                        _token: token,
                    },
                    success: function(response) {
                        if (response.flag == 1) {
                            let soLuongLay = modalElement.find("input[name='Count']").val()
                                .trim();
                            let soLuongTon = modalElement.find("td[data-id='SoLuong']").data(
                                "value");
                            if (soLuongLay === "") {
                                showToast("Chưa nhập số lượng cần lấy", "bg-warning",
                                    "fa-exclamation-circle");
                            } else if (soLuongLay <= 0) {
                                showToast("Số lượng lấy phải lớn hơn 0", "bg-warning",
                                    "fa-exclamation-circle");
                            } else if (soLuongTon === 0) {
                                showToast("Kho đã hết thùng hàng", "bg-warning",
                                    "fa-exclamation-circle");
                            } else {
                                let simple = $("tbody").find("#simple-" + id);
                                let cell = simple.closest("td");
                                cell.attr('data-value', soLuongLay);

                                if (soLuongLay > soLuongTon) {
                                    showToast("Số lượng lấy không được lớn hơn số lượng tồn",
                                        "bg-warning", "fa-exclamation-circle");
                                } else {
                                    cell.css("background-color", "#28a475").attr("isTake",
                                        true);
                                    showToast("Lấy thùng hàng thành công", "bg-success",
                                        "fa-check-circle");
                                    modalElement.modal("hide");
                                }
                            }
                        } else {
                            showToast(
                                "Chỉ lấy được thùng hàng từ đơn \"Sản xuất thùng hàng cho nội bộ\"",
                                "bg-warning",
                                "fa-exclamation-circle");
                            modalElement.modal("hide");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            });
            $("#saveBtn").on("click", function() {
                let cellElements = $("tbody td");
                let FK_Id_Order = $("input[name='FK_Id_Order']").val();
                let dataArr = [];

                cellElements.each(function() {
                    if ($(this).attr("istake")) {
                        let id = $(this).find(".small").attr("data-id");
                        let Count = $(this).data("value");
                        dataArr.push({
                            id: id,
                            Count: Count
                        });
                    }
                });

                if (dataArr.length === 0) {
                    window.location.href = '/orders/simples/createSimple?id=' + FK_Id_Order;
                } else {
                    $.ajax({
                        url: "/wares/freeContentSimple",
                        method: "POST",
                        dataType: "json",
                        data: {
                            dataArr: dataArr,
                            _token: token,
                        },
                        success: function(response) {},
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        },
                    });
                    $.ajax({
                        url: "{{ route('orders.simples.getSimple') }}",
                        method: "POST",
                        dataType: "json",
                        contentType: 'application/json',
                        data: JSON.stringify({
                            dataArr: dataArr,
                            FK_Id_Order: FK_Id_Order,
                            _token: token,
                        }),
                        success: function(response) {
                            var redirectUrl = response.url;
                            window.location.href = redirectUrl + '?id=' + response.id;
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                }
            });
        });
    </script>
@endpush
