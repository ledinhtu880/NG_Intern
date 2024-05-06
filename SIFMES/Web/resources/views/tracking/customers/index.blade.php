@extends('layouts.master')

@section('title', 'Theo dõi khách hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi khách hàng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Theo dõi khách hàng
        </h4>
    </div>
    <div class="row g-0 p-3 pb-0">
        <div class="col-md-12">
            <div class="w-25">
                <div class="input-group">
                    <label for="customerSelect" class="input-group-text">Chọn khách hàng</label>
                    <select name="customerSelect" id="customerSelect" class="form-select" tabindex="1">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->Id_Customer }}">{{ $customer->Name_Customer }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card gap-3">
                <div class="card-body" id="informationCustomer"></div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card gap-3">
                <div class="card-body" id="informationTransport"></div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-body p-0">
                    <h5 class="h5 fw-bold border-bottom px-3 pb-2 mb-3">
                        <i class="fa-solid fa-list-ul me-2"></i>
                        Bảng đơn đặt hàng của khách hàng
                    </h5>
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Ngày đặt hàng</th>
                                <th scope="col" class="py-2">Ngày giao hàng</th>
                                <th scope="col" class="py-2">Trạng thái</th>
                                <th scope="col" class="py-2 text-center">Trạng thái sản phẩm</th>
                                <th scope="col" class="py-2">Kiểu hàng</th>
                                <th scope="col" class="py-2 text-center">Xem</th>
                            </tr>
                        </thead>
                        <tbody id="orderInformation">
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
        $(document).ready(function() {
            $("#customerSelect").change(function() {
                $("#informationCustomer").html("");
                $("#informationTransport").html("");
                $("#orderInformation").html("");
                var id = $(this).val();
                $.ajax({
                    url: "/tracking/customers/getInformation",
                    type: "POST",
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        let customer = response.customer;
                        $("#informationCustomer").html(`
                            <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin khách hàng</h5>
                            <div class="row">
                                <div class="col-md-6">
                                <div class="row d-flex flex-column gap-3">
                                    <div class="input-group">
                                        <label for="Id_Customer" class="input-group-text" >Mã khách hàng</label>
                                        <input type="text" id="Id_Customer" class="form-control" value="${customer.Id_Customer}" readonly>
                                    </div>
                                    <div class="input-group">
                                        <label for="Name_Customer" class="input-group-text" >Họ và tên</label>
                                        <input type="text" id="Name_Customer" class="form-control" value="${customer.Name_Customer}" readonly>
                                    </div>
                                    <div class="input-group">
                                        <label for="ZipCode" class="input-group-text" >Zipcode</label>
                                        <input type="text" id="ZipCode" class="form-control" value="${customer.ZipCode}" readonly>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="row d-flex flex-column gap-3">
                                    <div class="input-group">
                                        <label for="Email" class="input-group-text" >Email</label>
                                        <input type="email" id="Email" class="form-control" value="${customer.Email}" readonly>
                                    </div>
                                    <div class="input-group">
                                        <label for="Phone" class="input-group-text" >Số điện thoại</label>
                                        <input type="email" id="Phone" class="form-control" value="${customer.Phone}" readonly>
                                    </div>
                                    <div class="input-group">
                                        <label for="Address" class="input-group-text" >Địa chỉ</label>
                                        <input type="email" id="Address" class="form-control" value="${customer.Address}" readonly>
                                    </div>
                                </div>
                                </div>
                            </div>`);
                        $("#informationTransport").html(`
                            <h5 class="h5 fw-bold border-bottom pb-2 mb-3">
                                <i class="fa-solid fa-train me-2"></i>
                                Thông tin đóng gói và vận chuyển của khách hàng
                            </h5>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group">
                                        <label for="" class="input-group-text">Phương thức vận chuyển</label>
                                        <div class="form-control">${customer.transportType}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <label for="" class="input-group-text">Kiểu khách hàng</label>
                                        <div class="form-control">${customer.customerType}</div>
                                    </div>
                                </div>
                            </div>`);

                        let data = response.data;
                        let count = 0;
                        let maxTabIndex = Math.max.apply(
                            null,
                            $("*")
                            .map(function() {
                                let tabIndex = $(this).attr("tabindex");
                                return tabIndex ?
                                    parseInt(tabIndex, 10) :
                                    -Infinity; // Chuyển đổi thành số nguyên
                            })
                            .get()
                        );
                        data.forEach((each) => {
                            let id = each.Id_Order;
                            let route =
                                each.SimpleOrPack == 1 ?
                                `/tracking/customers/showPacks/${id}` :
                                `/tracking/customers/showSimples/${id}`;
                            let progress = each.progress;
                            let status = each.status;
                            html = `<tr class="align-middle">
                                        <th scope="row" class="text-center text-body-secondary">
                                            ${id}
                                        </th>
                                        <td>${each.Date_Order != null ? formatDate(each.Date_Order) : 'Chưa giao hàng'}</td>
                                        <td>${each.Date_Delivery != null ? formatDate(each.Date_Delivery) : 'Chưa giao hàng'}</td>
                                        <td>${status}</td>
                                        <td class="text-center">
                                            <div class="progress h-100 position-relative">
                                                <span class="progress-bar-value fs-6 fw-bold">${progress}%</span>
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="${progress}" aria-valuemin="0"
                                                    aria-valuemax="100" style="width: ${progress}%;">
                                                    <span
                                                        class="progress-bar-value fs-6 fw-bold">${progress}%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${each.SimpleOrPack == 1 ? 'Gói hàng' : 'Thùng hàng'}</td>
                                        <td class="text-center">
                                            <a href="${route}" class="btn btn-sm btn-outline btn-detail" tabindex="${maxTabIndex + count}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>`;

                            count++;
                            $("#orderInformation").append(html);
                        })
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

            $("#customerSelect").change();
        });
    </script>
@endpush
