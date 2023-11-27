@extends('layouts.master')

@section('title', 'Điều phối đơn hàng')

@push('css')
<style>
    .form-check-input:checked {
        background-color: #2b4c72 !important;
        border-color: #2b4c72 !important;
        outline: none !important;
    }
</style>
@endpush

@section('content')
<div>
    <div class="container-fluid border-primary-subtle">
        <nav aria-label="breadcrumb" class="row mx-2 my-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Quản lý</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vận chuyển</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header btn-primary-color ">
                <h4 class="card-title">Xử lý đơn hàng</h4>
            </div>
            <div class="row my-3 px-3 py-1">
                <div class="col-2">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="trangthai">Hiển thị</label>
                        <select class="form-select" id="trangthai">
                            <option value="0">Sản xuất</option>
                            <option value="1">Đóng gói</option>
                            <option value="2">Giao hàng</option>
                        </select>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <th scope="col"></th>
                    <th scope="col">Mã đơn hàng</th>
                    <th scope="col">Kiểu gói</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Ngày giao hàng</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="row px-3 py-1">
                <div class="col-5">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="daychuyen">Dây chuyền sản xuất</label>
                        <select class="form-select" id="daychuyen">
                            @foreach ($psl as $item)
                            <option value="{{ $item->Id_ProdStationLine }}">{{ $item->Name_ProdStationLine }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="kieudon">Loại</label>
                        <input type="text" class="form-control" id="kieudon" readonly>
                    </div>
                </div>
                <div class="col-1">
                    <button class="btn btn-primary-color" data-bs-toggle="modal" data-bs-target="#modalstart"
                        id="khoidong">Khởi
                        động</button>
                    <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn chắc chắn muốn khởi động quá trình xử lí đơn hàng này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary btn-primary-color"
                                        data-bs-dismiss="modal" id="xacnhan">Xác
                                        nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Tổng quan</span>
                        <input type="text" class="form-control" id="tongquan" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
    $(document).ready(function () {
        let selectedValue = $('#daychuyen').val();
        $.ajax({
            url: '/dispatchs/getProductStation',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                value: selectedValue,
            },
            success: function (response) {
                $('#tongquan').val(response[0].Description);
                $('#kieudon').val(response[0].Name_OrderType);
            }
        });

        $('#daychuyen').change(function () {
            let selectedValue = $(this).val();
            $.ajax({
                url: '/dispatchs/getProductStation',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    value: selectedValue,
                },
                success: function (response) {
                    $('#tongquan').val(response[0].Description);
                    $('#kieudon').val(response[0].Name_OrderType);
                }
            });
        });

        $('#trangthai').change(function () {
            let selectedValue = $(this).val();
            $.ajax({
                url: '/dispatchs/getStatus',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    value: selectedValue,
                },
                success: function (response) {
                    let list = response;
                    $('.table tbody').empty();

                    for (let i = 0; i < list.length; i++) {
                        let element = list[i];
                        $newRow = $('<tr class="text-center"></tr>');
                        let col1 = $(
                            '<td> <input class="form-check-input me-1 checkbox" type="checkbox"></td>'
                        );
                        col1.find('input').attr('value', element['Id_OrderLocal']);
                        col1.find('input').attr('id', 'cb' + element['Id_OrderLocal']);
                        let col2 = $('<td></td>')
                        col2.text(element['Id_OrderLocal'])
                        let col3 = $('<td></td>');
                        element['SimpleOrPack'] ? col3.text("Thùng hàng") : col3.text(
                            "Gói hàng");
                        let col4 = $('<td></td>');
                        if (element['MakeOrPackOrExpedition'] == 0) {
                            col4.text("Sản xuất");
                        } else if (element['MakeOrPackOrExpedition'] == 1) {
                            col4.text("Đóng gói");
                        } else if (element['MakeOrPackOrExpedition'] == 2) {
                            col4.text("Giao hàng");
                        }
                        let col5 = $('<td></td>');
                        let a = $(
                            `<a class="text-decoration-none details btn btn-sm btn-outline-light
                                    text-primary-color border-secondary" target="_blank"><i class="fa-solid fa-eye"></i></a>`
                        );
                        a.attr('href', 'http://127.0.0.1:8000/orders/' + element[
                            'Id_OrderLocal']);
                        col5.append(a);

                        let col6 = $('<td></td>');
                        col6.text(element['Count']);

                        let col7 = $('<td></td>');
                        let dateTimeString = element['DateDilivery'];
                        let dateTime = new Date(dateTimeString);
                        let year = dateTime.getFullYear();
                        let month = ("0" + (dateTime.getMonth() + 1)).slice(-2);
                        let day = ("0" + dateTime.getDate()).slice(-2);

                        // Format the date string in the desired format
                        let formattedDate = year + "-" + month + "-" + day;
                        col7.text(formattedDate);
                        $newRow.append(col1, col2, col3, col4, col5, col6, col7);
                        $('.table tbody').append($newRow);
                    }
                }
            });
        });

        let firstOptionValue = $('#trangthai').val();
        // Gán giá trị cho phần tử select
        $('#trangthai').val(firstOptionValue);
        // Gọi sự kiện change để hiển thị dữ liệu
        $('#trangthai').change();

        let id = null;
        let count = 0;
        $(document).on("change", ".checkbox", function () {
            if ($(this).is(':checked')) {
                let checkedValue = $(this).attr('id');
                id = checkedValue.match(/\d+/)[0];
                count++;
            } else {
                count--;
            }
        })

        $('#khoidong').on('click', function () {
            if (count < 1) {
                alert("Bạn chưa chọn hoá đơn nào!");
                $('.modal').addClass('d-none');
                window.location.reload();
            } else if (count > 1) {
                alert("Bạn chỉ có thể xử lý 1 hoá đơn cùng lúc");
                $('.modal').addClass('d-none');
                window.location.reload();
            }
        });

        $('#xacnhan').on('click', function () {
            if (count == 1) {
                let daychuyen = $('#daychuyen option:selected').val();
                $('.modal').removeClass('d-none');
                $.ajax({
                    url: '/dispatchs/store',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        station: daychuyen,
                    },
                    success: function (response) {
                        alert("Khởi động đơn hàng thành công");
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush