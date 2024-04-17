@extends('layouts.master')

@section('title', 'Chi tiết kho chứa')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('wares.index') }}">Quản lý kho chứa</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Xem chi tiết</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Chi tiết kho chứa
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Cấu hình kho chứa</h5>
                    <div class="row">
                        <div class="col-8">
                            <div class="input-group">
                                <label class="input-group-text" for="ware">Kho chứa</label>
                                <select class="form-select" id="ware">
                                    @foreach ($stations as $each)
                                        <option value="{{ $each->Id_Station }}">{{ $each->Name_Station }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <span class="input-group-text">Số hàng</span>
                                <input type="number" class="form-control" min="1" id="rowNumber" name="rowNumber"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <span class="input-group-text">Số cột</span>
                                <input type="number" class="form-control" min="1" id="colNumber" name="colNumber"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Chi tiết kho chứa</h5>
                    <div class="px-1">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            let token = $('meta[name="csrf-token"]').attr("content");
            var ware = $('#ware option:selected').val();
            $.ajax({
                url: 'showDetails',
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
                                //newCol.text("Row " + i + ", Col " + j);
                                var info = $(
                                    '<p class="text-end position-absolute top-0 end-0 p-0 bg-transparent" style="font-size: 0.75rem"></p>'
                                );
                                info.text(i + '.' + j);
                                newCol.append(info);
                                newRow.append(newCol);
                            }

                            $('.table').append(newRow);
                        }
                        for (let i = 1; i <= col * row; i++) {
                            if (details[i - 1].FK_Id_StateCell == "1") {
                                $('#cell' + i).css("background-color", "#ffffff");
                                $('#cell' + i).attr("data-status", 1);
                                $('#cell' + i).append($('<p class="small">Trống</p>'));
                            } else if (details[i - 1].FK_Id_StateCell == "0") {
                                $('#cell' + i).css("background-color", "#d9d3c4");
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
                                                          <h4 class="modal-title" id="show-${details[i - 1].FK_Id_ContentSimple}Label">
                                                          Thông tin chi tiết đơn hàng số ${details[i - 1].FK_Id_ContentSimple}
                                                          </h4>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <div class="table-responsive">
                                                            <table class="table table-striped m-0">
                                                              <thead>
                                                                <tr class="align-middle">
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
                    <div class="modal-header" data-bs-theme="dark">
                      <h5 class="modal-title w-100" id="show-${details[i - 1].FK_Id_ContentPack}Label">
                      Thông tin chi tiết gói hàng số ${details[i - 1].FK_Id_ContentPack}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-striped m-0">
                        <thead>
                          <tr class="align-middle">
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

            $('#ware').change(function() {
                $('.table').empty();
                var ware = $(this).val();

                $.ajax({
                    url: 'showDetails',
                    method: 'POST',
                    data: {
                        ware: ware,
                        _token: token,
                    },
                    success: function(response) {
                        if (response == 0) {
                            $('.table').empty();
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
                                    //newCol.text("Row " + i + ", Col " + j);
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
                                    $('#cell' + i).css("background-color", "#d9d3c4");
                                    $('#cell' + i).attr("data-status", 0)
                                    $('#cell' + i).append($(
                                        '<p class="small">Không thể sử dụng</p>'));
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
                      <h5 class="modal-title w-100" id="show-${details[i - 1].FK_Id_ContentSimple}Label">
                      Thông tin chi tiết thùng hàng số ${details[i - 1].FK_Id_ContentSimple}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-striped m-0">
                          <thead>
                            <tr class="align-middle">
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
                    <div class="modal-header" data-bs-theme="dark">
                      <h5 class="modal-title w-100" id="show-${details[i - 1].FK_Id_ContentPack}Label">
                      Thông tin chi tiết gói hàng số ${details[i - 1].FK_Id_ContentPack}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-striped m-0">
                        <thead>
                          <tr class="align-middle">
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
            });

            function numberFormat(
                number,
                decimals,
                decimalSeparator,
                thousandSeparator
            ) {
                decimals = decimals !== undefined ? decimals : 0;
                decimalSeparator = decimalSeparator || ",";
                thousandSeparator = thousandSeparator || ".";

                var parsedNumber = parseFloat(number);
                var parts = parsedNumber.toFixed(decimals).split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);

                return parts.join(decimalSeparator);
            }

            $(document).on("click", ".simple", function() {
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
                        <td class="text-center">${numberFormat(
              value.Price_Container
            )} VNĐ </td>
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
                        htmls += `<tr class="align-middle">
                      <td class="text-center" data-id="SoLuong" data-value="${data.SoLuong}">${data.SoLuong}</td>
                      <td class="text-center">${numberFormat(data.Price_Pack)} VNĐ</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline btnDetail" data-bs-target="#showDetails-${data.Id_ContentPack}" 
                        data-id="${data.Id_ContentPack}" data-bs-toggle="modal">
                          <i class="fa-solid fa-eye"></i>
                        </button>
                      </td>
                    </tr>`;
                        table.html(htmls);

                        let modal = ` 
              <div class="modal fade bg-transparent" id="showDetails-${data.Id_ContentPack}" tabindex="-1"
                    aria-labelledby="#show-${data.Id_ContentPack}Label" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title fw-bold" id="show-${data.Id_ContentPack}Label">
                      Thông tin các thùng hàng của gói hàng số ${data.Id_ContentPack}
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="wrapper w-100 overflow-x-auto">
                        <div class="table-responsive">
                          <table class="table table-borderless table-hover m-0">
                            <thead class="table-heading">
                              <tr class="align-middle">
                                <th class="py-2" scope="col">Tên nguyên liệu</th>
                                <th class="py-2" scope="col">Số lượng nguyên liệu</th>
                                <th class="py-2" scope="col">Đơn vị</th>
                                <th class="py-2" scope="col">Thùng chứa</th>
                                <th class="py-2" scope="col">Số lượng thùng chứa</th>
                                <th class="py-2" scope="col">Đơn giá</th>
                              </tr>
                            </thead>
                            <tbody id="table-packs-${data.Id_ContentPack}" class="p-5">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="d-flex align-items-center justify-content-end w-100">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                      data-bs-target="#show-${data.Id_ContentPack}">
                        Quay lại
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>`
                        let cell = $("#pack-" + data.Id_ContentPack);
                        cell.parent().append(modal);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });
            $(document).on("click", ".btnDetail", function() {
                let id = $(this).data("id");
                let table = $(`#table-packs-${id}`)
                $.ajax({
                    url: "{{ route('wares.showSimpleInPack') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        htmls = "";
                        $.each(response.data, function(key, value) {
                            htmls += `<tr class="align-middle">
                        <td class="text-center">${value.Name_RawMaterial}</td>
                        <td class="text-center">${value.Count_RawMaterial}</td>
                        <td class="text-center">${value.Unit}</td>
                        <td class="text-center">${value.Name_ContainerType}</td>
                        <td class="text-center">${value.Count_Container}</td>
                        <td class="text-center">${numberFormat(
              value.Price_Container
            )} VNĐ </td>
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
        });
    </script>
@endpush
