@extends('layouts.master')

@section('title', 'Chi tiết kho thùng')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang
                            chủ</a></li>
                    <li class="breadcrumb-item active">
                        <a class="text-decoration-none" href="{{ route('wares.index') }}">Quản lý kho chứa</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết kho chứa</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header p-0 overflow-hidden">
                    <h4 class="card-title m-0 bg-primary-color p-3">Cấu hình kho chứa</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="ware">Kho chứa</label>
                                <select class="form-select" id="ware">
                                    @foreach ($stations as $each)
                                    <option value="{{ $each->Id_Station }}">{{ $each->Name_Station }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Số hàng</span>
                                <input type="number" class="form-control" min="1" id="rowNumber" name="rowNumber"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Số cột</span>
                                <input type="number" class="form-control" min="1" id="colNumber" name="colNumber"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header p-0 overflow-hidden">
                    <h4 class="card-title m-0 bg-primary-color p-3">Chi tiết kho chứa</h4>
                </div>
                <div class="card-body px-5 pb-5">
                    <h4 class="text-center">SỐ HÀNG VÀ CỘT CỦA KHO</h4>
                    <table class="table table-bordered border-black">
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
@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        var ware = $('#ware option:selected').val();
        $.ajax({
            url: 'showDetails',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                ware: ware,
            },
            success: function (response) {
                if (response == 0) {
                    $('#rowNumber').val("");
                    $('#colNumber').val("");
                } else {
                    var details = response.details;
                    var col = response.col;
                    var row = response.row;

                    $('#rowNumber').val(row);
                    $('#colNumber').val(col);
                    //    console.log(details);
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
                            var info = $('<p class="text-end position-absolute top-0 end-0"></p>');
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
                            $('#cell' + i).append($('<p class="small">Không thể sử dụng</p>'));
                        } else if (details[i - 1].FK_Id_StateCell == "2") {
                            $('#cell' + i).css("background-color", "rgb(166 191 247)");
                            $('#cell' + i).attr("data-status", 0)
                            $('#cell' + i).append(
                                $(`<p class="small">Thùng hàng số ${details[i - 1].FK_Id_SimpleContent}
                                        <button type="button" class="simple ms-3 btn btn-sm btn-outline-light
                                        text-primary-color border-secondary" data-bs-toggle="modal"
                                        data-bs-target="#show-${details[i - 1].FK_Id_SimpleContent}" data-id="${details[i - 1].FK_Id_SimpleContent}">
                                        <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </p>`)
                            );
                            let modals = `
                            <div class="modal fade" id="show-${details[i - 1].FK_Id_SimpleContent
                                }" tabindex="-1"
                                    aria-labelledby="#show-${details[i - 1].FK_Id_SimpleContent
                                }Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                                            <h5 class="modal-title w-100 " id="show-${details[i - 1].FK_Id_SimpleContent
                                }Label">
                                            Thông tin chi tiết đơn hàng số ${details[i - 1].FK_Id_SimpleContent
                                }
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped m-0">
                                            <thead>
                                                <tr>
                                                <th class="text-center" scope="col">Nguyên liệu</th>
                                                <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                                                <th class="text-center" scope="col">Đơn vị</th>
                                                <th class="text-center" scope="col">Thùng chứa</th>
                                                <th class="text-center" scope="col">Số lượng thùng chứa</th>
                                                <th class="text-center" scope="col">Đơn giá</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-simples" class="p-5"
                                                data-value="${details[i - 1].FK_Id_SimpleContent
                                }">
                                            </tbody>
                                            </table>
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

        $('#ware').change(function () {
            $('.table tr').empty();
            var ware = $(this).val();

            $.ajax({
                url: 'showDetails',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ware: ware,
                },
                success: function (response) {
                    if (response == 0) {
                        $('.table tr').empty();
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
                                    '<p class="text-end position-absolute top-0 end-0"></p>'
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
                                $('#cell' + i).css("background-color", "rgb(166 191 247)");
                                $('#cell' + i).attr("data-status", 0)
                                $('#cell' + i).append(
                                    $(`<p class="small">Thùng hàng số ${details[i - 1].FK_Id_SimpleContent}
            <button type="button" class="simple ms-3 btn btn-sm btn-outline-light
            text-primary-color border-secondary" data-bs-toggle="modal"
            data-bs-target="#show-${details[i - 1].FK_Id_SimpleContent}" data-id="${details[i - 1].FK_Id_SimpleContent}">
            <i class="fa-solid fa-eye"></i>
            </button>
        </p>`)
                                );
                                let modals = `
<div class="modal fade" id="show-${details[i - 1].FK_Id_SimpleContent
                                    }" tabindex="-1"
        aria-labelledby="#show-${details[i - 1].FK_Id_SimpleContent
                                    }Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                <h5 class="modal-title w-100 " id="show-${details[i - 1].FK_Id_SimpleContent
                                    }Label">
                Thông tin chi tiết đơn hàng số ${details[i - 1].FK_Id_SimpleContent
                                    }
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped m-0">
                <thead>
                    <tr>
                    <th class="text-center" scope="col">Nguyên liệu</th>
                    <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                    <th class="text-center" scope="col">Đơn vị</th>
                    <th class="text-center" scope="col">Thùng chứa</th>
                    <th class="text-center" scope="col">Số lượng thùng chứa</th>
                    <th class="text-center" scope="col">Đơn giá</th>
                    </tr>
                </thead>
                <tbody class="table-simples" class="p-5"
                    data-value="${details[i - 1].FK_Id_SimpleContent
                                    }">
                </tbody>
                </table>
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

        let token = $('meta[name="csrf-token"]').attr("content");
        $(document).on("click", ".simple", function () {
            let id = $(this).data("id");
            $.ajax({
                url: "{{ route('wares.showSimple') }}",
                method: "POST",
                dataType: "json",
                data: {
                    id: id,
                    _token: token,
                },
                success: function (response) {
                    let table;
                    $(".table-simples").each(function () {
                        if ($(this).data("value") == id) {
                            table = $(this);
                        }
                    });
                    let htmls = "";
                    $.each(response, function (key, value) {
                        htmls += `<tr>
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
                error: function (xhr) {
                    // Xử lý lỗi khi gửi yêu cầu Ajax
                    console.log(xhr.responseText);
                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        });
    });
</script>
@endpush