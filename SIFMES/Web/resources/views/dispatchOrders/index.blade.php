@extends('layouts.master')

@section('title', 'Điều phối đơn hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Khởi động đơn hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Khởi động đơn hàng</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-white">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="trangthai">Hiển thị</label>
                                <select class="form-select" id="trangthai">
                                    <option value="0">Sản xuất</option>
                                    <option value="1">Đóng gói</option>
                                    <option value="2">Giao hàng</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-3 d-none" id="rawSelectBox">
                                <label class="input-group-text" for="raw_type">Nguyên liệu</label>
                                <select class="form-select max-w-xl" id="raw_type">
                                    @foreach ($raw_type as $item)
                                        <option value="{{ $item->Id_RawMaterialType }}">{{ $item->Name_RawMaterialType }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 d-none" id="itemSelectBox">
                                <label class="input-group-text" for="item_type">Kiểu hàng</label>
                                <select class="form-select max-w-xl" id="item_type">
                                    <option value="0">Thùng hàng</option>
                                    <option value="1">Gói hàng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light text-center">
                            <th scope="col" class="py-3">Chọn</th>
                            <th scope="col" class="py-3">#</th>
                            <th scope="col" class="py-3">Kiểu gói</th>
                            <th scope="col" class="py-3">Trạng thái</th>
                            <th scope="col" class="py-3">Số lượng</th>
                            <th scope="col" class="py-3">Ngày giao hàng</th>
                            <th scope="col" class="py-3">Hoạt động</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-0 bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="daychuyen">Dây chuyền xử lý</label>
                                <select class="form-select" id="daychuyen">
                                    @foreach ($psl as $item)
                                        <option value="{{ $item->Id_ProdStationLine }}">{{ $item->Name_ProdStationLine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="kieudon">Loại</label>
                                <input type="text" class="form-control" id="kieudon" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Tổng quan</span>
                                <input type="text" class="form-control" id="tongquan" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-start gap-3">
                            <a href="{{ route('index') }}" class="btn btn-light">Quay lại</a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalstart"
                                id="khoidong">Khởi
                                động</button>
                            <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn chắc chắn muốn khởi động quá trình xử lí đơn hàng này?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-primary btn-primary"
                                                data-bs-dismiss="modal" id="xacnhan">Xác
                                                nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script>
        $(document).ready(function() {
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

            $('.modal').attr('id', 'abc');

            function appendToTable(element) {
                let route = null;
                if (element['MakeOrPackOrExpedition'] == 0) {
                    route = `/orderLocals/makes/${element['Id_OrderLocal']}`;
                } else if (element['MakeOrPackOrExpedition'] == 1) {
                    route = `/orderLocals/packs/showDetails/${element['Id_OrderLocal']}`;
                } else if (element['MakeOrPackOrExpedition'] == 2) {
                    route = `/orderLocals/expeditions/show/${element['Id_OrderLocal']}`;
                }

                let dateTimeString = element['Date_Delivery'];
                let dateTime = new Date(dateTimeString);
                let year = dateTime.getFullYear();
                let month = ("0" + (dateTime.getMonth() + 1)).slice(-2);
                let day = ("0" + dateTime.getDate()).slice(-2);
                let formattedDate = day + "-" + month + "-" + year;

                let html = `<tr class="text-center">
                              <td><input class="form-check-input me-1 checkbox" type="checkbox" value="${element['Id_OrderLocal']}" id="cb${element['Id_OrderLocal']}"></td>
                              <td>${element['Id_OrderLocal']}</td>
                              <td>
                                ${element['SimpleOrPack'] == 0 ? 'Thùng hàng' : 'Gói hàng'}
                              </td>
                              <td>
                                ${element['MakeOrPackOrExpedition'] == 0 ? 'Sản xuất' : element['MakeOrPackOrExpedition'] == 1 ? 'Đóng gói' :
                                element['MakeOrPackOrExpedition'] == 2 ? 'Giao hàng' : ''}
                              </td>
                              <td>${element['Count']}</td>
                              <td>${formattedDate}</td>
                              <td>
                                <a class="btn btn-sm text-secondary details" target="_blank" href="${route}">
                                  <i class="fa-solid fa-eye"></i>
                                </a>
                              </td>
                            </tr>`;
                $('.table tbody').append(html);
            }

            $('#daychuyen').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/dispatchs/getProductStation',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        value: selectedValue,
                    },
                    success: function(response) {
                        $('#tongquan').val(response[0].Description);
                        $('#kieudon').val(response[0].Name_OrderType);
                    }
                });
            });

            let secondOptionValue = $('#daychuyen').val();
            $('#daychuyen').val(secondOptionValue);
            $('#daychuyen').change();

            $('#raw_type').change(function() {
                id = [];
                let id_type = $(this).val();
                $.ajax({
                    url: '/dispatchs/showOrderByRawType',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_type: id_type,
                    },
                    success: function(response) {
                        let orderlocals = response.orderlocals;
                        let psl = response.psl;
                        $('.table tbody').empty();

                        for (let i = 0; i < orderlocals.length; i++) {
                            appendToTable(orderlocals[i]);
                        }

                        $('#daychuyen').empty();
                        psl.forEach(element => {
                            $('#daychuyen').append(
                                `<option value="${element.Id_ProdStationLine}">${element.Name_ProdStationLine}</option>`
                            );
                        });
                        $('#daychuyen').change();
                    }
                });
            });

            $('#item_type').change(function() {
                let itemType = $(this).val();
                $.ajax({
                    url: '/dispatchs/showOrderByItemType',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        itemType: itemType,
                    },
                    success: function(response) {
                        let orderlocals = response.orderlocals;
                        let psl = response.psl;
                        $('.table tbody').empty();
                        for (let i = 0; i < orderlocals.length; i++) {
                            appendToTable(orderlocals[i]);
                        }
                        $('#daychuyen').empty();
                        psl.forEach(element => {
                            $('#daychuyen').append(
                                `<option value="${element.Id_ProdStationLine}">${element.Name_ProdStationLine}</option>`
                            );
                        });
                        $('#daychuyen').change();
                    }
                });
            });


            $('#trangthai').change(function() {
                id = [];
                count = 0;
                $('.modal').attr('id', 'abc');
                var selectedValue = $(this).val();
                if (selectedValue == 0) {
                    $('#rawSelectBox').removeClass('d-none');
                    $('#itemSelectBox').addClass('d-none');
                    $('#raw_type').change();
                } else if (selectedValue == 1) {
                    $('#rawSelectBox').addClass('d-none');
                    $('#itemSelectBox').addClass('d-none');
                    $.ajax({
                        url: '/dispatchs/getStatus',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            value: selectedValue,
                        },
                        success: function(response) {
                            let orderlocals = response.orderlocals;
                            let psl = response.psl;
                            $('.table tbody').empty();

                            for (let i = 0; i < orderlocals.length; i++) {
                                appendToTable(orderlocals[i]);
                            }

                            $('#daychuyen').empty();
                            psl.forEach(element => {
                                $('#daychuyen').append(
                                    `<option value="${element.Id_ProdStationLine}">${element.Name_ProdStationLine}</option>`
                                );
                            });
                            $('#daychuyen').change();
                        }
                    });
                } else {
                    $('#rawSelectBox').addClass('d-none');
                    $('#itemSelectBox').removeClass('d-none');
                    $('#item_type').change();
                }
            });
            let firstOptionValue = $('#trangthai').val();
            $('#trangthai').val(firstOptionValue);
            $('#trangthai').change();
            var id = [];
            $(document).on("change", ".checkbox", function() {
                let checkedValue = $(this).attr('id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    id.push(checkedValue);
                } else {
                    id = id.filter(function(element) {
                        return element !== checkedValue;
                    });
                }

                if (id.length >= 1) {
                    $('.modal').attr('id', 'modalstart');
                } else {
                    $('.modal').attr('id', 'abc');
                }
            })

            let currentBgColorClass, currentIconClass;

            toastLiveExample.on('hidden.bs.toast', function() {
                $(".toast-body").removeClass(currentBgColorClass);
                $("#icon").removeClass(currentIconClass);
                $("#toast-msg").html('');
            });

            function showToast(message, bgColorClass, iconClass) {
                // Lưu trữ giá trị của tham số trong biến toàn cục
                currentBgColorClass = bgColorClass;
                currentIconClass = iconClass;

                $(".toast-body").addClass(bgColorClass);
                $("#icon").addClass(iconClass);
                $("#toast-msg").html(message);
                toastBootstrap.show();
            }

            $('#khoidong').on('click', function() {
                if (id.length < 1) {
                    showToast(
                        "Bạn chưa chọn hoá đơn nào!",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else if (id.length >= 1) {
                    $('#xacnhan').on('click', function() {
                        var daychuyen = $('#daychuyen option:selected').val();
                        $.ajax({
                            url: '/dispatchs/store',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id,
                                $stationProd: daychuyen,
                            },
                            success: function(response) {
                                showToast(
                                    "Khởi động đơn hàng thành công!",
                                    "bg-success",
                                    "fa-check-circle"
                                );
                                toastBootstrap.show();
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            }
                        });
                    })
                }
            });

        });
    </script>
@endpush