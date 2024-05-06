@extends('layouts.master')

@section('title', 'Theo dõi đơn hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Theo dõi đơn hàng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Theo dõi đơn hàng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <label class="input-group-text bg-body-tertiary" for="After_DateOrder">Ngày đặt hàng (Từ
                                    ngày)</label>
                                <input type="date" class="form-control" name="After_DateOrder" id="After_DateOrder"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" tabindex="1">
                            </div>
                            <span class="form-message text-danger"></span>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <label class="input-group-text bg-body-tertiary" for="Before_DateOrder">Ngày đặt hàng
                                    (Đến
                                    ngày)</label>
                                <input type="date" class="form-control" name="Before_DateOrder" id="Before_DateOrder"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" tabindex="2">
                                </select>
                            </div>
                            <span class="form-message text-danger"></span>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline" id="searchBtn" tabindex="3">
                                <i class="fa-solid fa-search me-2"></i>Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Tên khách hàng</th>
                                <th scope="col" class="py-2">Ngày đặt hàng</th>
                                <th scope="col" class="py-2">Ngày giao hàng</th>
                                <th scope="col" class="py-2">Trạng thái</th>
                                <th scope="col" class="py-2 text-center">Trạng thái sản phẩm</th>
                                <th scope="col" class="py-2">Kiểu hàng</th>
                                <th scope="col" class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @if (isset($data))
                                @foreach ($data as $each)
                                    @php
                                        $id = $each->Id_Order;
                                        $simpleOrPack = $each->SimpleOrPack;
                                    @endphp
                                    <tr class="align-middle">
                                        <th scope="row" class="text-center text-body-secondary">
                                            {{ $each->Id_Order }}
                                        </th>
                                        <td>{{ $each->Name_Customer }}</td>
                                        <td>
                                            {{ $each->Date_Order != null ? \Carbon\Carbon::parse($each->Date_Order)->format('d/m/Y') : 'Chưa giao hàng' }}
                                        </td>
                                        <td>{{ $each->Date_Delivery != null
                                            ? \Carbon\Carbon::parse($each->Date_Delivery)->format('d/m/Y')
                                            : 'Chưa giao hàng' }}
                                        </td>
                                        <td>{{ $each->status }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="progress h-100 position-relative">
                                                    <span
                                                        class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                    <div class="progress-bar" role="progressbar"
                                                        aria-valuenow="{{ $each->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: {{ $each->progress }}%;">
                                                        <span
                                                            class="progress-bar-value fs-6 fw-bold">{{ $each->progress }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $each->SimpleOrPack == 1 ? 'Gói hàng' : 'Thùng hàng' }}</td>
                                        @php
                                            $route =
                                                $simpleOrPack == 1
                                                    ? "/tracking/orders/showPacks/{$id}"
                                                    : "/tracking/orders/showSimples/{$id}";
                                        @endphp
                                        <td class="text-center">
                                            <a href="{{ $route }}" class="btn btn-sm btn-outline btn-detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (session('message') && session('type'))
        <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
                    <div class=" d-flex justify-content-center align-items-center gap-2">
                        @if (session('type') == 'success')
                            <i class="fas fa-check-circle text-light fs-5"></i>
                        @elseif(session('type') == 'danger' || session('type') == 'warning')
                            <i class="fas fa-xmark-circle text-light fs-5"></i>
                        @elseif(session('type') == 'info' || session('type') == 'secondary')
                            <i class="fas fa-info-circle text-light fs-5"></i>
                        @endif
                        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const toastLiveExample = $('#liveToast');
            const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
            toastBootstrap.show();

            let token = $('meta[name="csrf-token"]').attr("content");
            let firstControl = $("#After_DateOrder");
            let secondControl = $("#Before_DateOrder");

            $("#searchBtn").on('click', function(event) {
                if (secondControl.val() < firstControl.val()) {
                    secondControl.parent().next().html("Vui lòng chọn ngày phù hợp");
                    firstControl.parent().next().html("Vui lòng chọn ngày phù hợp");
                    secondControl.addClass("is-invalid");
                    firstControl.addClass("is-invalid");
                } else {
                    secondControl.parent().next().html("");
                    firstControl.parent().next().html("");
                    secondControl.removeClass("is-invalid");
                    firstControl.removeClass("is-invalid");
                }
                $.ajax({
                    url: '/tracking/orders/ShowOrderByDate',
                    type: "post",
                    data: {
                        dateAfter: firstControl.val(), // Corrected here
                        dateBefore: secondControl.val(), // Corrected here
                        _token: token,
                    },
                    success: function(response) {
                        let table = $("#table-data");
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
                        table.html("");
                        $.each(response.data, function(key, value) {
                            count++;
                            let id = value.Id_Order;
                            let route =
                                value.SimpleOrPack == 1 ?
                                `/tracking/orders/showPacks/${id}` :
                                `/tracking/orders/showSimples/${id}`;
                            let progress = value.progress;
                            let status = value.status;
                            html = `<tr class="align-middle">
                                        <td class="text-center">${id}</td>
                                        <td>${value.Name_Customer}</td>
                                        <td>${value.Date_Order != null ? formatDate(value.Date_Order) : 'Chưa giao hàng'}</td>
                                        <td>${value.Date_Delivery != null ? formatDate(value.Date_Delivery) : 'Chưa giao hàng'}</td>
                                        <td>${status}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="progress h-100 position-relative">
                                                    <span class="progress-bar-value fs-6 fw-bold">${progress}%</span>
                                                    <div class="progress-bar" role="progressbar"
                                                        aria-valuenow="${progress}" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: ${progress}%;">
                                                        <span
                                                            class="progress-bar-value fs-6 fw-bold">${progress}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${value.SimpleOrPack == 1 ? 'Gói hàng' : 'Thùng hàng'}</td>
                                        <td class="text-center">
                                            <a href="${route}" class="btn btn-sm btn-outline btn-detail" tabindex="${count + maxTabIndex}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                            table.append(html);
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });

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
            let count = 1;

            $("#table-data .btn.btn-detail").each(function() {
                $(this).attr("tabindex", count + maxTabIndex);
                count++;
            })
        });
    </script>
@endpush
