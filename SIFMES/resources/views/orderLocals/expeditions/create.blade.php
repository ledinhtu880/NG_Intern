@extends('layouts.master')

@section('title', 'Tạo đơn giao hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Tạo đơn giao hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn giao hàng</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Danh sách đơn hàng</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group" style="width: 200px;">
                            <label class="input-group-text bg-secondary-subtle" for="Kho">Kho</label>
                            <select name="kho" id="kho" class="form-select">
                                <option value="406">406</option>
                                <option value="409">409</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-expedition mt-4">
                        <thead class="table-light" id="table-heading">
                            <th scope="col" class="py-3 text-center">Chọn</th>
                            <th scope="col" class="py-3 text-center">Mã đơn hàng</th>
                            <th scope="col" class="py-3">Khách hàng</th>
                            <th scope="col" class="py-3">Kiểu hàng</th>
                            <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
                            <th scope="col" class="py-3 text-center">Đơn giá</th>
                        </thead>
                        <tbody id="table-data">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-content-center justify-content-between">
                        <button type="submit" class="btn btn-primary px-3" id="them">
                            <i class="fa-solid fa-plus text-white me-2"></i>Thêm
                        </button>
                        <div class="input-group" style="width: 300px;">
                            <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                                Ngày giao hàng
                            </label>
                            <input type="date" name="Date_Delivery" id="Date_Delivery" class="form-control"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">Đơn giao hàng</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">Chọn</th>
                                <th scope="col" class="py-3 text-center">Mã đơn hàng</th>
                                <th scope="col" class="py-3 text-center">Số lượng</th>
                                <th scope="col" class="py-3">Kiểu thùng</th>
                                <th scope="col" class="py-3">Trạng thái</th>
                                <th scope="col" class="py-3 text-center">Ngày giao hàng</th>
                                <th scope="col" class="py-3 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="table-result">
                            @foreach ($data as $each)
                                <tr>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="input-check form-check-input checkbox2"
                                            value="{{ $each->Id_OrderLocal }}" data-id="cb{{ $each->Id_OrderLocal }}">
                                    </td>
                                    <td class="text-center">{{ $each->Id_OrderLocal }}</td>
                                    <td class="text-center">{{ $each->Count }}</td>
                                    <td>
                                        <span class="badge text-bg-primary fw-normal fs-6">{{ $each->type }}</span>
                                    </td>
                                    <td>{{ $each->status }}</td>
                                    <td class="text-center">{{ $each->deliveryDate }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btnShow btn btn-sm text-secondary"
                                            data-bs-toggle="modal" data-bs-target="#show-{{ $each->Id_OrderLocal }}"
                                            data-id="{{ $each->Id_OrderLocal }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <div class="modal fade" id="show-{{ $each->Id_OrderLocal }}" tabindex="-1"
                                            aria-labelledby="show-{{ $each->Id_OrderLocal }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold text-secondary"
                                                            id="exampleModalLabel">
                                                            Thông tin chi tiết đơn hàng số
                                                            {{ $each->Id_OrderLocal }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-details table-striped m-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" scope="col">Nguyên liệu
                                                                    </th>
                                                                    <th class="text-center" scope="col">Số lượng nguyên
                                                                        liệu</th>
                                                                    <th class="text-center" scope="col">Đơn vị</th>
                                                                    <th class="text-center" scope="col">Thùng chứa</th>
                                                                    <th class="text-center" scope="col">Số lượng thùng
                                                                        chứa</th>
                                                                    <th class="text-center" scope="col">Đơn giá</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-simples" class="p-5"
                                                                data-value="{{ $each->Id_OrderLocal }}">
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
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <button class="btn btn-primary px-3" id="xoa">
                        <i class="fa-solid fa-minus text-white me-2"></i>Xóa
                    </button>
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="{{ route('orderLocals.expeditions.index') }}" class="btn btn-light">Quay lại</a>
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

            $('#kho').change(function() {
                var selectedValue = $(this).val();
                count1 = 0;
                count2 = 0;
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
                                    `<tr>
                  <td class="text-center align-middle">
                      <input class="form-check-input checkbox1" type="checkbox" value="${element['Id_ContentSimple']}" 
                      id="cb${element['Id_ContentSimple']}" data-id="${element['Id_ContentPack']}">
                  </td>
                  <td class="text-center">${element['Id_Order']}</td>
                  <td>${element['Name_Customer']}</td>
                  <td>
                      ${type_container}
                  </td>
                  <td class="text-center">${element['Count_Container']}</td>
                  <td class="text-center">${numberFormat(element['Price_Container'])} VNĐ</td>
              </tr>`;
                                $('.table-expedition tbody').append(html);
                            } else if (selectedValue == 409) {
                                let simpleOrPack = '';
                                if (element['SimpleOrPack'] == 0) {
                                    simpleOrPack = "Thùng hàng";
                                } else if (element['SimpleOrPack'] == 1) {
                                    simpleOrPack = "Gói hàng";
                                }
                                let html = `<tr>
              <td class="text-center align-middle">
                  <input class="form-check-input checkbox1" type="checkbox" value="${element['Id_ContentPack']}" id="cb${element['Id_ContentPack']}" data-id="${element['Id_ContentPack']}">
              </td>
              <td class="text-center">${element['Id_Order']}</td>
              <td>${element['Name_Customer']}</td>
              <td>${simpleOrPack}</td>
              <td class="text-center">${element['Count_Pack']}</td>
              <td class="text-center">${numberFormat(element['Price_Pack'])} VNĐ</td>
          </tr>`;
                                $('.table-expedition tbody').append(html);
                            }
                        }
                    }
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
                    id1.push(checkedValue);
                    count1++;

                } else {
                    count1--;
                    id1 = id1.filter(function(element) {
                        return element !== checkedValue;
                    });
                }
            })

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

            $('.btnShow').on('click', function() {
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

                            let html = `<tr class="text-center">
                          <td>${element['Name_RawMaterial']}</td>
                          <td>${Number(element['Count_RawMaterial']).toLocaleString()}</td>
                          <td>${element['Unit']}</td>
                          <td>
                              ${type_container}
                          </td>
                          <td>${element['Count_Container']}</td>
                          <td>${Number(element['Price_Container'])} VNĐ</td>
                      </tr>`;

                            $('.table-details').append(html);
                        }
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    }
                });
            });

            $('#them').on('click', function() {
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
                        }
                    });
                }
            });

            $('#xoa').on('click', function() {
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
                        }
                    });
                }
            });
        });
    </script>
@endpush
