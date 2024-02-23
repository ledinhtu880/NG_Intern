@extends('layouts.master')

@section('title', 'Thêm kho chứa')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Thêm kho chứa</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('wares.index') }}">Quản lý kho chứa</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Cấu hình kho chứa</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="warehouse">Kho chứa</label>
                                    <select class="form-select" name="FK_Id_Station" id="warehouse">
                                        @foreach ($stations as $each)
                                            <option value="{{ $each->Id_Station }}">{{ $each->Name_Station }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Nhập số hàng</span>
                                    <input type="number" class="form-control" min="1" maxlength="3" id="colNumber"
                                        name="colNumber">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Nhập số cột</span>
                                    <input type="number" class="form-control" min="1" id="rowNumber" maxlength="3"
                                        name="rowNumber">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="showBtn">
                                    Xem trước
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Chi tiết kho chứa</h4>
                </div>
                <div class="card-body px-5">
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
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary d-none" id="saveBtn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Lưu</button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn chắc chắn muốn khởi tạo kho này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                            id="confirmBtn">Xác nhận</button>
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
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

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

            let token = $('meta[name="csrf-token"]').attr("content");
            var data = [];

            function preview() {
                data.length = 0;
                $('.table').empty();
                var col = $('#rowNumber').val();
                var row = $('#colNumber').val();;
                var count = 0;
                for (var i = 1; i <= row; i++) {
                    var newRow = $('<tr></tr>');

                    for (var j = 1; j <= col; j++) {
                        count++;
                        var newCol = $('<td class="position-relative"></td>');
                        newCol.addClass("square-cell");
                        newCol.attr("data-col", +j);
                        newCol.attr("data-row", +i);
                        newCol.attr("id", "cell" + count);
                        newCol.attr("data-status", 1);
                        var info = $(
                            '<p class="text-end position-absolute top-0 end-0 p-0 bg-transparent" style="font-size: 0.75rem"></p>'
                        );
                        info.text(i + '.' + j);
                        newCol.append(info);
                        newCol.css("background-color", "#ffffff");
                        newCol.append($('<p class="small">Trống</p>'));
                        newRow.append(newCol);

                        data.push([i, j, 1]);
                    }
                    $('.table').append(newRow);
                }
            }

            function showDetails() {
                var ware = $('#warehouse option:selected').val();
                $.ajax({
                    url: 'showDetails',
                    method: 'POST',
                    data: {
                        ware: ware,
                        _token: token
                    },
                    success: function(response) {
                        if (response.count == 0) {} else {
                            $('#showBtn').prop('disabled', true);
                            $('#saveBtn').addClass('d-none');
                            var details = response.details;
                            var col = response.col;
                            var row = response.row;
                            $('#rowNumber').val(row)
                            $('#colNumber').val(col)
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
                                if (details[i - 1].FK_Id_StateCell == "1") {
                                    $('#cell' + i).css("background-color", "#ffffff");
                                    $('#cell' + i).attr("data-status", 1);
                                    $('#cell' + i).append($('<p class="small">Trống</p>'));
                                } else if (details[i - 1].FK_Id_StateCell == "0") {
                                    $('#cell' + i).css("background-color", "#dbd6d6");
                                    $('#cell' + i).attr("data-status", 0)
                                    $('#cell' + i).append($('<p class="small">Không thể sử dụng</p>'));
                                } else if (details[i - 1].FK_Id_StateCell == "2") {
                                    if (ware == 406) {
                                        $('#cell' + i).css("background-color", "#A6BFF7");
                                        $('#cell' + i).attr("data-status", 0)
                                        $('#cell' + i).append(
                                            $(`<p class="small text-truncate" data-id="${details[i - 1].FK_Id_ContentSimple}"
                                                        id="simple-${details[i - 1].FK_Id_ContentSimple}">Thùng hàng <br> số ${details[i - 1].FK_Id_ContentSimple} <br>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary btnShowSimple" data-bs-toggle="modal"
                                                        data-bs-target="#show-${details[i - 1].FK_Id_ContentSimple}"
                                                        data-id="${details[i - 1].FK_Id_ContentSimple}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button> </p>`));
                                        let modals = `
                                                  <div class="modal fade bg-transparent" id="show-${details[i - 1].FK_Id_ContentSimple}" tabindex="-1"
                                                        aria-labelledby="#show-${details[i - 1].FK_Id_ContentSimple}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h4 class="modal-title fw-bold text-secondary" id="show-${details[i - 1].FK_Id_ContentSimple}Label">
                                                          Thông tin chi tiết thùng hàng số ${details[i - 1].FK_Id_ContentSimple}
                                                          </h4>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <div class="table-responsive">
                                                            <table class="table table-striped m-0">
                                                              <thead>
                                                                <tr>
                                                                  <th scope="col" style="width: 110px;">Nguyên liệu</th>
                                                                  <th scope="col" style="width: 200px;">Số lượng nguyên liệu</th>
                                                                  <th scope="col" style="width: 110px;">Đơn vị</th>
                                                                  <th scope="col" style="width: 110px;">Thùng chứa</th>
                                                                  <th scope="col" style="width: 200px;">Tổng số lượng trong kho</th>
                                                                  <th scope="col" style="width: 200px;">Số lượng khả dụng</th>
                                                                  <th scope="col" style="width: 110px;">Đơn giá</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody class="table-simples" data-value="${details[i - 1].FK_Id_ContentSimple}">
                                                              </tbody>
                                                            </table>
                                                          </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="d-flex align-items-stretch justify-content-end">
                                                              <div class="d-flex gap-2">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                              </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>`
                                        $('#cell' + i).append(modals);
                                    } else {
                                        $('#cell' + i).css("background-color", "#A6BFF7");
                                        $('#cell' + i).attr("data-status", 0)
                                        $('#cell' + i).append(
                                            $(`<p class="small text-truncate" data-id="${details[i - 1].FK_Id_ContentPack}"
                                                id="pack-${details[i - 1].FK_Id_ContentPack}">Gói hàng<br> số ${details[i - 1].FK_Id_ContentPack}<br> 
                                                <button type="button" class="btn btn-sm btn-outline-secondary btnShowPack" data-bs-toggle="modal"
                                                data-bs-target="#show-${details[i - 1].FK_Id_ContentPack}"
                                                data-id="${details[i - 1].FK_Id_ContentPack}">
                                                <i class="fa-solid fa-eye"></i>
                                            </button> </p>`));
                                        let modals = `
                                        <div class="modal fade bg-transparent" id="show-${details[i - 1].FK_Id_ContentPack}" tabindex="-1"
                                              aria-labelledby="#show-${details[i - 1].FK_Id_ContentPack}Label" aria-hidden="true">
                                          <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                              <div class="modal-header>
                                                <h4 class="modal-title fw-bold text-secondary" id="show-${details[i - 1].FK_Id_ContentPack}Label">
                                                Thông tin chi tiết gói hàng số ${details[i - 1].FK_Id_ContentPack}
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <table class="table table-striped m-0">
                                                  <thead>
                                                    <tr>
                                                      <th class="text-center" scope="col">Tổng số lượng trong kho</th>
                                                      <th class="text-center" scope="col">Đơn giá gói hàng</th>
                                                      <th class="text-center" scope="col">Xem chi tiết</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody class="table-packs" class="p-5"
                                                      data-value="${details[i - 1].FK_Id_ContentPack}">
                                                  </tbody>
                                                </table>
                                              </div>
                                              <div class="modal-footer">
                                                <div class="d-flex align-items-stretch justify-content-between w-100">
                                                    <div class="input-group w-50">
                                                      <label class="input-group-text" for="Count">Số lượng</label>
                                                      <input type="number" name="Count" id="Count" class="form-control">
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
                    }
                });
            }
            showDetails();
            $('#warehouse').change(function() {
                var ware = $(this).val();
                $('#colNumber').val("");
                $('#rowNumber').val("");
                $('.table').empty();

                $.ajax({
                    url: 'showDetails',
                    method: 'POST',
                    data: {
                        ware: ware,
                        _token: token
                    },
                    success: function(response) {
                        if (response.count == 0) {
                            $('.table').empty();
                            $('#showBtn').prop('disabled', false);
                            $('#saveBtn').addClass('d-none');
                        } else {
                            $('#showBtn').prop('disabled', true);
                            showDetails();
                        }

                    }
                });
            });
            var isModalOpen = false;
            $.contextMenu({
                selector: ".square-cell",
                build: function($trigger) {
                    if (isModalOpen) {
                        return false; // Ngăn chặn hiển thị contextMenu khi modal đang mở
                    }
                    var options = {
                        callback: function(key, options) {
                            var col = $(this).data('col');
                            var row = $(this).data('row');
                            var ware = $('#warehouse option:selected').val();
                            var check = $('#showBtn').prop('disabled');
                            if (check) {
                                $.ajax({
                                    url: 'setCellStatus',
                                    method: 'POST',
                                    data: {
                                        row: row,
                                        col: col,
                                        ware: ware,
                                        status: key,
                                        _token: token
                                    },
                                    success: function(response) {
                                        $('.table').empty();
                                        showDetails();
                                    },
                                });
                            } else {
                                var cellID = $('[data-col="' + col + '"][data-row="' + row +
                                    '"]').attr('id');
                                var id = cellID.match(/\d+/)[0];
                                if (key == 0) {
                                    $(this).attr('data-status', key);
                                    $(this).css("background-color", "#dbd6d6");
                                    $(this).find('.small').text("Không thể sử dụng");
                                    data[id - 1] = [row, col, Number(key)];
                                } else if (key == 1) {
                                    $(this).attr('data-status', key);
                                    $(this).css("background-color", "#ffffff");
                                    $(this).find('.small').text("Trống");
                                    data[id - 1] = [row, col, Number(key)];
                                }
                            }
                        },
                        items: {}
                    };

                    var status = $trigger.attr('data-status');
                    if (status == 1) {
                        options.items = {
                            0: {
                                name: "Không thể sử dụng",
                            },
                            1: {
                                name: "Trống",
                                disabled: true,
                            },
                        };
                    } else {
                        options.items = {
                            0: {
                                name: "Không thể sử dụng",
                                disabled: true,
                            },
                            1: {
                                name: "Trống",
                            },
                        };
                    }
                    return options;
                }
            });
            $('#showBtn').click(function(e) {
                e.preventDefault();
                var col = $('#rowNumber').val();
                var row = $('#colNumber').val();
                $('#saveBtn').prop('disabled', false);
                if (col !== "" && row !== "") {
                    if (/^\d+$/.test(col) && /^\d+$/.test(row)) {
                        if (parseInt(col, 10) > 0 && parseInt(row, 10) > 0) {
                            preview();
                            $('#saveBtn').removeClass('d-none');
                        } else {
                            showToast(
                                "Số hàng và cột phải lớn hơn 0!",
                                "bg-warning",
                                "fa-exclamation-circle"
                            );
                        }
                    } else {
                        showToast(
                            "Vui lòng nhập lại!",
                            "bg-warning",
                            "fa-exclamation-circle"
                        );
                    }

                } else {
                    showToast(
                        "Vui lòng điền đầy đủ số hàng và số cột",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                }
            });
            $(document).on("click", ".btnShowSimple", function() {
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
                        isModalOpen = true;
                        let table;
                        $(".table-simples").each(function() {
                            if ($(this).data("value") == id) {
                                table = $(this);
                            }
                        });
                        let htmls = "";
                        $.each(response, function(key, value) {
                            htmls += `<tr>
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
            $(document).on("click", ".btnShowPack", function() {
                let id = $(this).data("id");
                $.ajax({
                    url: "{{ route('wares.showPack') }}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        isModalOpen = true;
                        let table;
                        $(".table-packs").each(function() {
                            if ($(this).data("value") == id) {
                                table = $(this);
                            }
                        });
                        let htmls = "";
                        let data = response;
                        htmls += `<tr>
                      <td class="text-center" data-id="SoLuong" data-value="${data.SoLuong}">${data.SoLuong}</td>
                      <td class="text-center">${numberFormat(data.Price_Pack)} VNĐ</td>
                      <td class="text-center">
                        <button class="btn btn-sm btnDetail border-secondary" data-bs-target="#showDetails-${data.Id_ContentPack}" 
                        data-id="${data.Id_ContentPack}" data-bs-toggle="modal">
                          <i class="fa-solid fa-eye"></i>
                        </button>
                      </td>
                    </tr>`;
                        table.html(htmls);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });
            $(document).on('hidden.bs.modal', '.modal', function() {
                isModalOpen = false;
            });

            $('#confirmBtn').click(function(e) {
                e.preventDefault();
                $('.table').empty();
                var rowNumber = $('#rowNumber').val();
                var colNumber = $('#colNumber').val();
                var ware = $('#warehouse option:selected').val();
                $.ajax({
                    url: 'createWare',
                    method: 'POST',
                    data: {
                        data: JSON.stringify(data),
                        ware: ware,
                        col: rowNumber,
                        row: colNumber,
                        _token: token

                    },
                    success: function(response) {
                        if (response.flag) {
                            showToast(
                                "Khởi tạo kho thành công",
                                "bg-success",
                                "fa-check-circle"
                            );
                            $('#rowNumber').val("");
                            $('#colNumber').val("");
                            $('.table').empty();
                        } else {
                            showToast(
                                "Khởi tạo kho thất bại, kho đã tồn tại!",
                                "bg-warning",
                                "fa-exclamation-circle"
                            );
                            toastBootstrap.show();
                            $('.table').empty();
                        }
                        showDetails();
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            })
        });
    </script>
@endpush
