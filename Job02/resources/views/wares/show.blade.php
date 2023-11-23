@extends('layouts.master')

@section('title', 'Chi tiết kho thùng')

@push('css')
<style>
    .square-cell {
        width: 100px;
        /* Adjust the width as needed */
        height: 100px;
        /* Adjust the height as needed */
        text-align: center;
        /* Optional: Center the content within the square cell */
        vertical-align: middle;
        /* Optional: Vertically center the content within the square cell */
    }

    .small {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endpush

@section('content')
<div class="container-fluid border border-dark-subtle ">
    <div class="card">
        <div class="card-header d-flex align-items-center" style="background-color: #2b4c72">
            <h6 class="" style="color: white">Cấu hình kho chứa</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="khochua">Kho chứa</label>
                        <select class="form-select" id="khochua">
                            @foreach($stations as $each)
                            <option value="{{ $each->Id_Station }}">{{ $each->Name_Station }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Số hàng</span>
                        <input type="number" class="form-control" min="1" id="sohang" name="sohang" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Số cột</span>
                        <input type="number" class="form-control" min="1" id="socot" name="socot" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-header" style="background-color: #2b4c72">
            <h6 style="color: white">Chi tiết kho chứa</h6>
        </div>
        <div class="card-body px-5 pb-5">
            <h4 class="text-center">SỐ HÀNG VÀ CỘT CỦA KHO</h4>
            <table class="table table-bordered border-primary">
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
@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        var kho = $('#khochua option:selected').val();
        $.ajax({
            url: 'show',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                kho: kho,
            },
            success: function (response) {
                if (response == 0) {
                    $('#sohang').val("");
                    $('#socot').val("");
                } else {
                    var details = response.details;
                    var col = response.col;
                    var row = response.row;

                    $('#sohang').val(row);
                    $('#socot').val(col);
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
                            $('#cell' + i).css("background-color", "rgb(166 191 247)");
                            $('#cell' + i).attr("data-status", 1);
                            $('#cell' + i).append($('<p class="small">Trống</p>'));
                        } else if (details[i - 1].FK_Id_StateCell == "0") {
                            $('#cell' + i).css("background-color", "#dbd6d6");
                            $('#cell' + i).attr("data-status", 0)
                            $('#cell' + i).append($('<p class="small">Không thể sử dụng</p>'));
                        }
                    }
                }
            }
        });

        $('#khochua').change(function () {
            $('.table tr').empty();
            var kho = $(this).val();

            $.ajax({
                url: 'show',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    kho: kho,
                },
                success: function (response) {
                    if (response == 0) {
                        $('.table tr').empty();
                        $('#sohang').val("");
                        $('#socot').val("");
                    } else {
                        var details = response.details;
                        var col = response.col;
                        var row = response.row;
                        $('#sohang').val(row);
                        $('#socot').val(col);
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
                                var info = $('<p class="text-end position-absolute top-0 end-0"></p>');
                                info.text(i + '.' + j);
                                newCol.append(info);
                                newRow.append(newCol);
                            }
                            $('.table').append(newRow);
                        }
                        for (var i = 1; i <= col * row; i++) {
                            if (details[i - 1].FK_Id_StateCell == "1") {
                                $('#cell' + i).css("background-color", "rgb(166 191 247)");
                                $('#cell' + i).attr("data-status", 1)
                                $('#cell' + i).append($('<p class="small">Trống</p>'));
                            } else if (details[i - 1].FK_Id_StateCell == "0") {
                                $('#cell' + i).css("background-color", "#dbd6d6");
                                $('#cell' + i).attr("data-status", 0)
                                $('#cell' + i).append($('<p class="small">Không thể sử dụng</p>'));
                            }
                        }
                    }
                }
            });
        });
    });
</script>
@endpush