@extends('layouts.master')

@section('title', 'Theo dõi đơn hàng nội bộ')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Theo dõi đơn hàng nội bộ</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi đơn hàng nội bộ</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="w-25 mb-4">
                <div class="input-group">
                    <label for="typeSelect" class="input-group-text p-2">Đơn hàng</label>
                    <select name="typeSelect" id="typeSelect" class="form-select">
                        <option value="0">Sản xuất</option>
                        <option value="1">Đóng gói</option>
                        <option value="2">Giao hàng</option>
                    </select>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-white">
                    <h4 class="card-title m-0 fw-bold text-body-secondary">
                        <i class="fa-solid fa-list-ul me-3"></i>
                        Bảng đơn hàng nội bộ
                        </h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Kiểu hàng</th>
                                <th scope="col" class="py-3 text-center">Số lượng</th>
                                <th scope="col" class="py-3 text-center">Ngày bắt đầu</th>
                                <th scope="col" class="py-3 text-center">Ngày giao hàng</th>
                                <th scope="col" class="py-3 text-center">Ngày hoàn thành</th>
                                <th scope="col" class="py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="orderInformation">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $("document").ready(function() {
            $("#typeSelect").change(function() {
                var typeOrderLocal = $(this).val();
                $.ajax({
                    url: "/tracking/orderlocals/",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        typeOrderLocal: typeOrderLocal,
                    },
                    success: function(response) {
                        htmls = ``;
                        $.each(response, function(index, value) {
                            let Id_OrderLocal = value.Id_OrderLocal;
                            let Date_Delivery = value.Date_Delivery;
                            let Count = value.Count;
                            let Date_Start = value.Date_Start;
                            let Date_Fin =
                                value.Date_Fin === null ?
                                "Chưa hoàn thành" :
                                formatDate(value.Date_Fin);
                            let check = value.SimpleOrPack;
                            let SimpleOrPack = check == 0 ? "Thùng hàng" : "Gói hàng";
                            let route =
                                value.SimpleOrPack == 1 ?
                                `/tracking/orderlocals/showPacks/${Id_OrderLocal}` :
                                `/tracking/orderlocals/showSimples/${Id_OrderLocal}`;
                            htmls += `<tr>
                          <td class="text-center align-middle">${Id_OrderLocal}</td>
                          <td>${SimpleOrPack}</td>
                          <td class="text-center align-middle">${Count}</td>
                          <td class="text-center align-middle">${formatDate(Date_Start)}</td>
                          <td class="text-center align-middle">${formatDate(Date_Delivery)}</td>
                          <td class="text-center align-middle">${Date_Fin}</td>
                          <td class="text-center align-middle">
                              <a href="${route}" class="btn btn-sm text-secondary"><i class="fa-solid fa-eye"></i></a>
                          </td>
                     </tr>`;
                        });
                        $(".orderInformation").html(htmls);
                    },
                    error: function(err) {
                        console.log(err.responseText);
                    },
                });
            });

            $("#typeSelect").change();
        });
    </script>
@endpush
