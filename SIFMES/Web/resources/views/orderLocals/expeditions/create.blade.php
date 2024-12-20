@extends('layouts.master')

@section('title', 'Tạo đơn giao hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orderLocals.expeditions.index') }}">Quản lý đơn giao hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Tạo đơn giao hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 id="card-title" class="h5 fw-bold border-bottom pb-2 mb-3">Danh sách đơn hàng có các thùng hàng kèm
                        theo</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="input-group" style="width: 200px;">
                            <label class="input-group-text bg-secondary-subtle" for="Kho">Kho</label>
                            <select name="kho" id="kho" class="form-select" tabindex="1">
                                <option value="406">406</option>
                                <option value="409">409</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-borderless table-hover m-0 table-expedition">
                        <thead class="table-heading text-center">
                            <th scope="col" class="py-2">Chọn</th>
                            <th scope="col" class="py-2">Mã đơn hàng</th>
                            <th scope="col" class="py-2">Khách hàng</th>
                            <th scope="col" class="py-2" id="material">Nguyên liệu</th>
                            <th scope="col" class="py-2">Kiểu hàng</th>
                            <th scope="col" class="py-2">Số lượng ban đầu</th>
                            <th scope="col" class="py-2">Số lượng đã lấy</th>
                            <th scope="col" class="py-2">Đơn giá</th>
                        </thead>
                        <tbody id="table-data">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-content-center justify-content-between">
                        <button type="submit" class="btn btn-primary px-3" id="addBtn" tabindex="3">
                            <i class="fa-solid fa-plus text-white me-2"></i>Thêm
                        </button>
                        <div class="input-group" style="width: 300px;">
                            <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                                Ngày giao hàng
                            </label>
                            <input type="date" name="Date_Delivery" id="Date_Delivery" class="form-control"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" tabindex="2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Đơn giao hàng</h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle text-center">
                                <th scope="col" class="py-2">Chọn</th>
                                <th scope="col" class="py-2">Mã đơn hàng</th>
                                <th scope="col" class="py-2">Số lượng</th>
                                <th scope="col" class="py-2">Kiểu thùng</th>
                                <th scope="col" class="py-2">Trạng thái</th>
                                <th scope="col" class="py-2">Ngày giao hàng</th>
                                <th scope="col" class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody id="table-result">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-content-center justify-content-between">
                        <button class="btn btn-primary px-3" id="deleteBtn" tabindex="4">
                            <i class="fa-solid fa-minus text-white me-2"></i>Xóa
                        </button>
                        <div class="d-flex align-items-center justify-content-end" tabindex="5">
                            <a href="{{ route('orderLocals.expeditions.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
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

                $(".toast-body").addClass(bgColorClass);
                $("#icon").addClass(iconClass);
                $("#toast-msg").html(message);
                toastBootstrap.show();
            }

            $('#kho').change(function() {
                var selectedValue = $(this).val();
                count1 = 0;
                count2 = 0;
                if (selectedValue == 406) {
                    $("#card-title").text("Danh sách đơn hàng có các thùng hàng kèm theo")
                    $("#material").show();
                } else {
                    $("#card-title").text("Danh sách đơn hàng có các gói hàng kèm theo")
                    $("#material").hide();
                }
                $.ajax({
                    url: '/orderLocals/expeditions/getOrder',
                    method: 'POST',
                    data: {
                        _token: token,
                        value: selectedValue,
                    },
                    success: function(response) {
                        var list = response;
                        $('.table-expedition tbody').empty();
                        for (let i = 0; i < list.length; i++) {
                            var element = list[i];
                            if (selectedValue == 406) {
                                let type_container = '';
                                if (element['FK_Id_ContainerType'] == 0) {
                                    type_container = "Hộp vuông";
                                } else if (element['FK_Id_ContainerType'] == 1) {
                                    type_container = "Hộp tròn";
                                }
                                let html =
                                    `<tr class="align-middle text-center">
                                        <td>
                                            <input class="form-check-input checkbox1" type="checkbox" value="${element['Id_ContentSimple']}" 
                                            id="cb${element['Id_ContentSimple']}" data-id="${element['Id_ContentPack']}">
                                        </td>
                                        <td>${element['Id_Order']}</td>
                                        <td>${element['Name_Customer']}</td>
                                        <td>${element['Name_RawMaterial']}</td>
                                        <td>${type_container}</td>
                                        <td>${element['Count_Container']}</td>
                                        <td id="count">${element['TotalTaken'] == null ? 0 : element['TotalTaken']}</td>
                                        <td>${numberFormat(element['Price_Container'])} VNĐ</td>
                                    </tr>`;
                                $('.table-expedition tbody').append(html);
                            } else if (selectedValue == 409) {
                                let html = `<tr class="align-middle text-center">
                                                <td>
                                                    <input class="form-check-input checkbox1" type="checkbox" value="${element['Id_ContentPack']}" id="cb${element['Id_ContentPack']}" data-id="${element['Id_ContentPack']}">
                                                </td>
                                                <td>${element['Id_Order']}</td>
                                                <td>${element['Name_Customer']}</td>
                                                <td>${element['Status']}</td>
                                                <td>${element['Count_Pack']}</td>
                                                <td id="count">${element['TotalTaken'] == null ? 0 : element['TotalTaken']}</td>
                                                <td>${numberFormat(element['Price_Pack'])} VNĐ</td>
                                            </tr>`;
                                $('.table-expedition tbody').append(html);
                            }
                        }
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
                $.ajax({
                    url: '/orderLocals/expeditions/showOrderExpedition',
                    method: 'POST',
                    data: {
                        _token: token,
                        value: selectedValue,
                    },
                    success: function(response) {
                        let html = '';
                        $.each(response, function(key, each) {
                            if (each.MakeOrPackOrExpedition == 0) {
                                each.status = "Sản xuất";
                            } else if (each.MakeOrPackOrExpedition == 1) {
                                each.status = "Gói hàng";
                            } else if (each.MakeOrPackOrExpedition == 2) {
                                each.status = "Giao hàng";
                            }
                            each.type = each.SimpleOrPack == 0 ? 'Thùng hàng' :
                                'Gói hàng'
                            html += `<tr class="align-middle text-center">
                                    <td>
                                        <input type="checkbox" class="input-check form-check-input checkbox2"
                                            value="${each.Id_OrderLocal}" data-id="cb${each.Id_OrderLocal}">
                                    </td>
                                    <td>${each.Id_OrderLocal}</td>
                                    <td>${each.Count}</td>
                                    <td>
                                        <span class="badge badge-main fw-normal fs-6">${each.type}</span>
                                    </td>
                                    <td>${each.status}</td>
                                    <td>${formatDate(each.Date_Delivery)}</td>
                                    <td>
                                        <button type="button" class="btnShow btn btn-sm btn-outline" data-bs-toggle="modal"
                                            data-bs-target="#show-${each.Id_OrderLocal}"
                                            data-id="${each.Id_OrderLocal}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="show-${each.Id_OrderLocal}" tabindex="-1"
                                            aria-labelledby="show-${each.Id_OrderLocal}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="exampleModalLabel">
                                                            Thông tin chi tiết đơn hàng số
                                                            ${each.Id_OrderLocal}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table
                                                            class="table table-hover table-borderless table-details m-0">
                                                            <thead class="table-heading">
                                                                <tr class="align-middle text-center">
                                                                    <th scope="col">Nguyên liệu</th>
                                                                    <th scope="col">Số lượng nguyên liệu</th>
                                                                    <th scope="col">Đơn vị</th>
                                                                    <th scope="col">Thùng chứa</th>
                                                                    <th scope="col">Số lượng ban đầu
                                                                    </th>
                                                                    <th scope="col">Số lượng đã lấy</th>
                                                                    <th scope="col">Đơn giá</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-simples" class="p-5"
                                                                data-value="${each.Id_OrderLocal}">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`
                        })
                        $('#table-result').html(html);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

            $('#kho').change();

            var id1 = [];
            var id2 = [];
            var count1 = 0;
            var count2 = 0;
            $(document).on("change", ".checkbox1", function() {
                let checkedValue = $(this).attr('id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    let rowData = {};
                    rowData.id = checkedValue;
                    rowData.Count = $(this).parent().parent().find('td#count').text();
                    id1.push(rowData);
                    count1++;
                } else {
                    count1--;
                    id1 = id1.filter(function(element) {
                        return element.id !== checkedValue;
                    });
                }
            });

            $(document).on("change", ".checkbox2", function() {
                let checkedValue = $(this).attr('data-id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    id2.push(checkedValue);
                    count2++;
                } else {
                    count2--;
                    id2 = id2.filter(function(element) {
                        return element !== checkedValue;
                    });
                }
            })

            $(document).on("click", ".btnShow", function() {
                let id = $(this).attr('data-id').match(/\d+/)[0];
                $('.table-details tbody tr').empty();
                $.ajax({
                    url: '/orderLocals/expeditions/showDetails',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        var details = response;
                        for (let index = 0; index < details.length; index++) {
                            let element = details[index];
                            let type_container = '';
                            if (element['FK_Id_ContainerType'] == 0) {
                                type_container = "Hộp vuông";
                            } else if (element['FK_Id_ContainerType'] == 1) {
                                type_container = "Hộp tròn";
                            }

                            let html = `<tr class="text-center align-middle">
                                <td>${element['Name_RawMaterial']}</td>
                                <td>${Number(element['Count_RawMaterial']).toLocaleString()}</td>
                                <td>${element['Unit']}</td>
                                <td>${type_container}</td>
                                <td>${element['Count_Container']}</td>
                                <td>${element['TotalTaken']}</td>
                                <td>${Number(element['Price_Container'])} VNĐ</td>
                            </tr>`;
                            $('.table-details').append(html);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

            $('#addBtn').on('click', function() {
                if (count1 < 1) {
                    showToast(
                        "Bạn chưa chọn hoá đơn nào để tạo đơn giao!",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    var kho = $('#kho option:selected').val();
                    var date = $('#Date_Delivery').val();
                    $.ajax({
                        url: '/orderLocals/expeditions/store',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id1,
                            station: kho,
                            date: date,
                        },
                        success: function(response) {
                            showToast(
                                "Tạo đơn giao hàng thành công",
                                "bg-success",
                                "fa-check-circle"
                            );
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                }
            });

            $('#deleteBtn').on('click', function() {
                if (count2 < 1) {
                    showToast(
                        "Bạn chưa chọn hoá đơn nào để xoá!",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    $.ajax({
                        url: '/orderLocals/expeditions/delete',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id2,
                        },
                        success: function(response) {
                            if (response == true) {
                                showToast(
                                    "Đơn hàng đã được khởi động, không thể xóa",
                                    "bg-warning",
                                    "fa-exclamation-circle"
                                );
                            } else {
                                showToast(
                                    "Xoá đơn giao hàng thành công",
                                    "bg-success",
                                    "fa-check-circle"
                                );
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                }
            });
        });
    </script>
@endpush
