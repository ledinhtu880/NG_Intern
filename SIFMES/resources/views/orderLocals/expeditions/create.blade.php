@extends('layouts.master')

@section('title', 'Tạo đơn giao hàng')

@push('css')
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row pb-5">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="w-75">
                    <div class="card mb-2">
                        <div class="card-header p-0 overflow-hidden">
                            <h4 class="card-title m-0 bg-primary-color p-3">Order lines</h4>
                        </div>
                        <div class="card-body px-0">
                            <div class="px-3 mb-3 d-flex justify-content-between align-items-center">
                                <div class="input-group" style="width: 200px;">
                                    <label class="input-group-text bg-secondary-subtle" for="Kho">Kho</label>
                                    <select name="kho" id="kho" class="form-select">
                                        <option value="406">406</option>
                                        <option value="409">409</option>
                                    </select>
                                </div>
                            </div>
                            <table class="table text-center table-expedition table-striped m-0">
                                <thead id="table-heading">
                                    <th scope="col">Chọn</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Kiểu hàng</th>
                                    <th scope="col">Số lượng thùng chứa</th>
                                    <th scope="col">Đơn giá thùng chứa</th>
                                    {{-- <th scope="col">Chọn</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Ghi chú</th> --}}
                                </thead>
                                <tbody id="table-data">
                                    {{-- <tr data-bs-toggle="collapse" data-bs-target="#demo3">
                                        <td class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="flexRadioDefault1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="hiddenRow">
                                            <div id="demo3" class="accordian-body collapse">Demo3 sadasdasdasdasdas
                                            </div>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex align-content-center justify-content-between">
                                <button type="submit" class="btn btn-primary-color px-3" id="them">
                                    <i class="fa-solid fa-plus text-white me-2"></i>Thêm
                                </button>
                                <div class="input-group" style="width: 300px;">
                                    <label class="input-group-text bg-secondary-subtle" for="DateDilivery">
                                        Ngày giao hàng
                                    </label>
                                    <input type="date" name="DateDilivery" id="DateDilivery" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header p-0 overflow-hidden">
                            <h4 class="card-title m-0 bg-primary-color p-3">Đơn giao hàng</h4>
                        </div>
                        <div class="card-body px-0">
                            <table class="table table-striped m-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">Chọn</th>
                                        <th class="text-center" scope="col">Mã đơn hàng</th>
                                        <th class="text-center" scope="col">Số lượng</th>
                                        <th class="text-center" scope="col">Kiểu hàng</th>
                                        <th class="text-center" scope="col">Trạng thái</th>
                                        <th class="text-center" scope="col">Ngày giao hàng</th>
                                        <th class="text-center" scope="col">Mô tả</th>
                                    </tr>
                                </thead>
                                <tbody id="table-result">
                                    @foreach ($data as $item)
                                        <tr class="text-center">
                                            <td><input type="checkbox" class="input-check checkbox2"
                                                    value="{{ $item->Id_OrderLocal }}"
                                                    data-id="cb{{ $item->Id_OrderLocal }}"></td>
                                            <td>{{ $item->Id_OrderLocal }}</td>
                                            <td>{{ $item->Count }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->deliveryDate }}</td>
                                            <td><button type="button"
                                                    class="btnShow btn btn-sm btn-outline-light
                                                text-primary-color border-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#show-{{ $item->Id_OrderLocal }}"
                                                    data-id="{{ $item->Id_OrderLocal }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <div class="modal fade" id="show-{{ $item->Id_OrderLocal }}" tabindex="-1"
                                                    aria-labelledby="show-{{ $item->Id_OrderLocal }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header p-2 bg-primary-color text-start"
                                                                data-bs-theme="dark">
                                                                <h5 class="modal-title w-100 " id="exampleModalLabel">
                                                                    Thông tin chi tiết đơn hàng số
                                                                    {{ $item->Id_OrderLocal }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-details table-striped m-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" scope="col">Nguyên
                                                                                liệu</th>
                                                                            <th class="text-center" scope="col">Số
                                                                                lượng
                                                                                nguyên liệu</th>
                                                                            <th class="text-center" scope="col">Đơn vị
                                                                            </th>
                                                                            <th class="text-center" scope="col">Thùng
                                                                                chứa</th>
                                                                            <th class="text-center" scope="col">Số
                                                                                lượng
                                                                                thùng chứa</th>
                                                                            <th class="text-center" scope="col">Đơn giá
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-simples" class="p-5"
                                                                        data-value="{{ $item->Id_OrderLocal }}">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary-color px-3" id="xoa">
                                <i class="fa-solid fa-minus text-white me-2"></i>Xóa
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end my-3">
                        <a href="{{ route('orderLocals.expeditions.index') }}" class="btn btn-warning px-4">Quay lại</a>
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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
@endsection


@push('javascript')
    <script>
        $(document).ready(function() {
            const toastLiveExample = $("#liveToast");
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            $('#kho').change(function() {
                var selectedValue = $(this).val();
                count1 = 0;
                count2 = 0;
                $.ajax({
                    url: '/orderLocals/expeditions/getOrder',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        value: selectedValue,
                    },
                    success: function(response) {
                        var list = response;
                        // console.log(list);
                        $('.table-expedition tbody').empty();
                        for (let i = 0; i < list.length; i++) {
                            var element = list[i];
                            if (selectedValue == 406) {
                                $newRow = $('<tr class="text-center"></tr>');
                                var col1 = $(
                                    '<td class="d-flex justify-content-center"> <input class="form-check me-1 checkbox1" type="checkbox"></td>'
                                );
                                col1.find('input').attr('value', element['Id_SimpleContent']);
                                col1.find('input').attr('id', 'cb' + element[
                                    'Id_SimpleContent']);
                                col1.find('input').attr('data-id', element['Id_PackContent']);
                                var col = $('<td></td>');
                                col.text(element['Id_Order']);
                                var col2 = $('<td></td>')
                                col2.text(element['Name_Customer'])
                                var col3 = $('<td></td>');
                                if (element['FK_Id_ContainerType'] == 0) {
                                    col3.text("Hộp vuông");
                                } else if (element['FK_Id_ContainerType'] == 1) {
                                    col3.text("Hộp tròn");
                                }
                                var col4 = $('<td></td>');
                                col4.text(element['Count_Container']);

                                var col5 = $('<td></td>');
                                var price = Number(element['Price_Container']);
                                col5.text(price.toLocaleString() + ' VNĐ');

                                let col6 = $('<td></td>');
                                $newRow.append(col1, col, col2, col3, col4, col5);
                                $('.table-expedition tbody').append($newRow);

                                // <tr data-bs-toggle="collapse" data-bs-target="#demo3">
                                //         <td class="d-flex justify-content-center">
                                //             <div class="form-check">
                                //                 <input class="form-check-input" type="radio" id="flexRadioDefault1">
                                //             </div>
                                //         </td>
                                //     </tr>
                                //     <tr>
                                //         <td colspan="6" class="hiddenRow">
                                //             <div id="demo3" class="accordian-body collapse">Demo3 sadasdasdasdasdas
                                //             </div>
                                //         </td>
                                //     </tr>

                                // Hiển thị từng hoá đơn ứng với các kho
                                // let newRow = $('<tr data-bs-toggle="collapse" class="text-center row_order"></tr>');
                                // newRow.attr('data-bs-target', '#order' + element['Id_Order']);
                                // newRow.attr('id', element['Id_Order']);
                                // let col1 = $(
                                //     '<td class="d-flex justify-content-center"><div class="form-check"><input class="form-check me-1 radio" type="radio"></div></td>'
                                // );
                                // col1.find('input').attr('id', 'rd' + element['Id_Order']);
                                // let col2 = $('<td></td>');
                                // col2.text(element['Id_Order']);
                                // let col3 = $('<td></td>');
                                // col3.text(element['Name_Customer']);
                                // let col4 = $('<td></td>');
                                // col4.text(element['Note']);
                                // newRow.append(col1, col2, col3, col4);
                                // $('.table-expedition tbody').append(newRow);
                                // ////


                                // // Hiển thị thông tin chi tiết 
                                // let rowDetail = $('<tr><td colspan="6" class="hiddenRow"></td></tr>');
                                // let colDetails = $('<div class="accordian-body collapse">Hellooo</div>');
                                // colDetails.attr('id', 'order'+element['Id_Order']);
                                // rowDetail.find('td').append(colDetails);
                                // $('.table-expedition tbody').append(rowDetail);
                                ///
                                // $('.table-expedition tbody').append(rowDetail);
                            } else if (selectedValue == 409) {
                                let newRow = $('<tr class="text-center"></tr>');
                                let col1 = $(
                                    '<td class="d-flex justify-content-center"> <input class="form-check me-1 checkbox1" type="checkbox"></td>'
                                );
                                col1.find('input').attr('value', element['Id_PackContent']);
                                col1.find('input').attr('id', 'cb' + element['Id_PackContent']);
                                col1.find('input').attr('data-id', element['Id_PackContent']);
                                let col = $('<td></td>');
                                col.text(element['Id_Order']);
                                var col2 = $('<td></td>')
                                col2.text(element['Name_Customer'])
                                let col3 = $('<td></td>');
                                if (element['SimpleOrPack'] == 0) {
                                    col3.text("Thùng hàng");
                                } else if (element['SimpleOrPack'] == 1) {
                                    col3.text("Gói hàng");
                                }
                                let col4 = $('<td></td>');
                                col4.text(element['Count_Pack']);

                                let col5 = $('<td></td>');
                                let price = Number(element['Price_Pack']);
                                col5.text(price.toLocaleString() + ' VNĐ');

                                newRow.append(col1, col, col2, col3, col4, col5);
                                $('.table-expedition tbody').append(newRow);
                            }
                        }
                    }
                });
            });

            let firstOptionValue = $('#kho').val();
            // Gán giá trị cho phần tử select
            $('#kho').val(firstOptionValue);
            // Gọi sự kiện change để hiển thị dữ liệu
            $('#kho').change();

            var id1 = [];
            var id2 = null;
            var count1 = 0;
            var count2 = 0;
            $(document).on("change", ".checkbox1", function() {
                let checkedValue = $(this).attr('id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    console.log(id1);
                    id1.push(checkedValue);
                    count1++;

                } else {
                    count1--;
                    id1 = id1.filter(function(element) {
                        return element !== checkedValue;
                    });
                }
                console.log(id1);
            })

            $(document).on("change", ".checkbox2", function() {
                if ($(this).is(':checked')) {
                    let checkedValue = $(this).attr('data-id');
                    id2 = checkedValue.match(/\d+/)[0];
                    count2++;
                    console.log(id2);
                } else {
                    count2--;
                }
            })

            // $('.table-expedition').on('click', '.row_order', function(){
            //     let id = $(this).attr('id');
            //     $.ajax({
            //         url: '/orderLocals/expeditions/getDetailSimple',
            //         method: 'POST',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         data: {
            //             id: id,
            //         },
            //     });
            // });

            $('.btnShow').on('click', function() {
                let id = $(this).attr('data-id');
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
                            let row = $('<tr class="text-center"></tr>');
                            let col1 = $("<td>" + element['Name_RawMaterial'] + "</td>");

                            let count = Number(element['Count']);
                            let col2 = $("<td>" + count.toLocaleString() + "</td>");

                            let col3 = $("<td>" + element['Unit'] + "</td>");

                            let col4 = $('<td></td>')
                            if (element['FK_Id_ContainerType'] == 0) {
                                col4.text("Hộp vuông");
                            } else if (element['FK_Id_ContainerType'] == 1) {
                                col4.text("Hộp tròn");
                            }

                            let col5 = $("<td>" + element['Count_Container'] + "</td>");

                            let price = Number(element['Price_Container']);
                            let col6 = $("<td>" + price + " VNĐ</td>")

                            row.append(col1, col2, col3, col4, col5, col6);
                            $('.table-details').append(row);
                        }


                    }
                });
            });

            $('#them').on('click', function() {
                if (count1 < 1) {
                    alert("Bạn chưa chọn hoá đơn nào!");
                } else {
                    var kho = $('#kho option:selected').val();
                    var date = $('#DateDilivery').val();
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
                            $(".toast-body").addClass("bg-success");
                            $("#icon").addClass("fa-check-circle");
                            $("#toast-msg").html("Tạo đơn giao hàng  thành công");
                            toastBootstrap.show();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    });
                }
            });

            $('#xoa').on('click', function() {
                if (count2 < 1) {
                    alert("Bạn chưa chọn hoá đơn nào để xoá!");
                } else if (count2 > 1) {
                    alert("Bạn chỉ có thể xoá 1 hoá đơn cùng lúc");
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
                            $(".toast-body").addClass("bg-success");
                            $("#icon").addClass("fa-check-circle");
                            $("#toast-msg").html("Xoá đơn giao hàng thành công");
                            toastBootstrap.show();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        });
    </script>
@endpush
