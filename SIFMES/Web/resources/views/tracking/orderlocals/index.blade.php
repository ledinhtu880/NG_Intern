@extends('layouts.master')

@section('title', 'Theo dõi đơn hàng nội bộ')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi đơn hàng nội bộ</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Theo dõi đơn hàng nội bộ
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <div class="w-25">
                        <div class="input-group">
                            <label for="typeSelect" class="input-group-text p-2">Đơn hàng</label>
                            <select name="typeSelect" id="typeSelect" class="form-select">
                                <option value="0">Sản xuất</option>
                                <option value="1">Đóng gói</option>
                                <option value="2">Giao hàng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Kiểu hàng</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Ngày bắt đầu</th>
                                <th scope="col" class="py-2 text-center">Ngày giao hàng</th>
                                <th scope="col" class="py-2 text-center">Ngày hoàn thành</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
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
                            htmls += `<tr class="align-middle">
                                        <th scope="row" class="text-center text-body-secondary">
                                            ${Id_OrderLocal}
                                        </th>
                                        <td>${SimpleOrPack}</td>
                                        <td class="text-center">${Count}</td>
                                        <td class="text-center">${formatDate(Date_Start)}</td>
                                        <td class="text-center">${formatDate(Date_Delivery)}</td>
                                        <td class="text-center">${Date_Fin}</td>
                                        <td class="text-center">
                                            <a href="${route}" class="btn btn-sm btn-outline"><i class="fa-solid fa-eye"></i></a>
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
