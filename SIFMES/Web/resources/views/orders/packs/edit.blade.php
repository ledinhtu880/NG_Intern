@extends('layouts.master')

@section('title', 'Sửa gói hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Sửa đơn gói hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin chung</h5>
                    <input type="hidden" name="Id_Order" value="{{ $order->Id_Order }}">
                    <form method="POST" id="formInformation">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="FK_Id_Customer" class="form-label">Khách hàng</label>
                                            <select class="form-select selectValidate" id="FK_Id_Customer"
                                                name="FK_Id_Customer" tabindex="1">
                                                @foreach ($customers as $each)
                                                    <option value="{{ $each->Id_Customer }}"
                                                        @if ($order->FK_Id_Customer == $each->Id_Customer) selected @endif>
                                                        {{ $each->Name_Customer }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <l for="Date_Order" class="form-label">Ngày đặt hàng</l abel>
                                            <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                                                value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Order)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Order)->format('Y-m-d') }}"
                                                tabindex="3">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="Date_Delivery" class="form-label">Ngày giao hàng</label>
                                            <input type="date" class="form-control" id="Date_Delivery"
                                                name="Date_Delivery"
                                                value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Delivery)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Delivery)->format('Y-m-d') }}"
                                                tabindex="2">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="Date_Reception" class="form-label">Ngày nhận hàng</label>
                                            <input type="date" class="form-control" id="Date_Reception"
                                                name="Date_Reception"
                                                value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Reception)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Reception)->format('Y-m-d') }}"
                                                tabindex="4">
                                        </div>
                                        <span class="form-message text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Note" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" aria-label="Notes" name="Note" id="Note" rows="5" tabindex="5">{{ $order->Note }}</textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin gói hàng</h5>
                    <table class="table m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" style="width: 200px;">Số lượng</th>
                                <th scope="col" class="text-center">Đơn giá</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col" class="text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @if (isset($contentPack))
                                @foreach ($contentPack as $each)
                                    <tr class="js-row align-middle" data-id="{{ $each->Id_ContentPack }}">
                                        <form method="POST">
                                            <td class="text-center align-middle ">
                                                <span class="Id_ContentPack">
                                                    {{ $each->Id_ContentPack }}
                                                </span>
                                            </td>
                                            <td class="text-center input-group">
                                                <input type="number" class="form-control Count_Pack" id="Count_Pack"
                                                    value="{{ $each->Count_Pack }}" min="1" name="Count_Pack"
                                                    required>
                                                <label for="Count_Pack" class="input-group-text">gói hàng</label>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
                                            </td>
                                            <td class="text-center align-middle" data-id="Status"
                                                data-value="{{ $each->Status == 'Sản xuất mới' ? 0 : 1 }}">
                                                <span class="badge badge-main fw-normal fs-6">{{ $each->Status }}</span>
                                            </td>
                                            <td class="text-center align-middle ">
                                                @if ($each->Status == 'Sản xuất mới')
                                                    <a href="{{ route('orders.packs.editSimpleInPack', ['id' => $each->Id_ContentPack]) }}"
                                                        class="btn btn-sm btn-outline">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-outline"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteID-{{ $each->Id_ContentPack }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteID-{{ $each->Id_ContentPack }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel">Xác
                                                                    nhận</h1>
                                                                    <button type="button"
                                                                        class="btn-close"data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-0">Bạn chắc chắn muốn xóa gói hàng này?
                                                                </p>
                                                                <p class="m-0">
                                                                    Việc này sẽ xóa gói hàng vĩnh viễn. <br>
                                                                    Hãy chắc chắn trước khi tiếp tục.
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-danger deletePack"
                                                                    data-id="{{ $each->Id_ContentPack }}">Xác
                                                                    nhận</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $order->Id_Order }}" tabindex="6">
                            Lưu
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $order->Id_Order }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Xác nhận
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật đơn gói hàng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Xác nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script type="text/javascript">
    function validateInput(element, message) {
        $(element).on("blur", function() {
            if ($(this).val() == "") {
                $(this).addClass("is-invalid");
                $(this).next().show();
                if ($(this).attr("id") == "Note") {
                    $(this).next().text(message);
                    $(this).next().show();
                } else {
                    $(this).closest(".input-group").next().text(message);
                    $(this).closest(".input-group").next().show();
                }
            } else {
                if ($(this).attr("id") == "Note") {
                    $(this).next().hide();
                } else {
                    $(this).closest(".input-group").next().hide();
                }
                $(this).removeClass("is-invalid");
            }
        });
    }

    $(document).ready(function() {
        validateInput("#Note");
        let token = $('meta[name="csrf-token"]').attr("content");
        const toastLiveExample = $("#liveToast");
        const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

        toastLiveExample.on('hidden.bs.toast', function() {
            var bgColorClass = $(".toast-body").data("bg-color-class");
            var iconClass = $("#icon").data("icon-class");

            $(".toast-body").removeClass(bgColorClass);
            $("#icon").removeClass(iconClass);

            $("#toast-msg").html('');
        });

        function showToast(message, bgColorClass, iconClass) {
            $(".toast-body").data("bg-color-class", bgColorClass);
            $("#icon").data("icon-class", iconClass);

            $(".toast-body").addClass(bgColorClass);
            $("#icon").addClass(iconClass);
            $("#toast-msg").html(message);
            toastBootstrap.show();
        }

        $(".js-row").each(function(index, element) {
            let isTake = $(element).find("td[data-id='Status']").data("value");
            if (isTake == 1) {
                let id = $(this).data("id");
                $.ajax({
                    url: "/wares/disabledContentPack",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function(response) {
                        if (!response) {
                            $(element).find("input[name='Count_Pack']").prop("disabled",
                                true)
                        } else {
                            $(element).find("input[name='Count_Pack']").prop("disabled",
                                false)
                        }
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert(
                            "Có lỗi xảy ra. Vui lòng thử lại sau."
                        );
                    },
                });
            }
        });
        $(".deletePack").on('click', function() {
            let Id_ContentPack = $(this).data('id');
            let modalElement = $("#deleteID-" + Id_ContentPack); // Lấy modal tương ứng với hàng
            let rowElement = $(this).closest('tr[data-id="' + Id_ContentPack + '"]');
            let isTake = rowElement.find('td[data-id="Status"]').data("value");
            $.ajax({
                url: '/orders/packs/destroyContentPack',
                type: 'POST',
                data: {
                    _token: token,
                    idContentPack: Id_ContentPack,
                    isTake: isTake,
                },
                success: function(response) {
                    modalElement.on("hidden.bs.modal", function() {
                        showToast("Xóa gói hàng thành công", "bg-success",
                            "fa-check-circle");
                        rowElement.remove();
                    });

                    // Đóng modal
                    modalElement.modal("hide");
                }
            });
        })

        function getValueIntoArr(name) {
            let arr = name.map(function() {
                return $(this).val();
            }).get();
            return arr;
        }
        $("#saveBtn").on("click", function() {
            let isValid = true;
            $(".Count_Pack").each(function(element) {
                if ($(this).val() == "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                }
            })

            if (isValid) {
                let idContentPacks = $(".Id_ContentPack").map(function() {
                    return $(this).html();
                }).get();

                // Bỏ ký tự \n và khoảng cách thừa, chỉ lấy số
                idContentPacks = idContentPacks.map(function(element) {
                    let res = $.trim(element);
                    return res;
                })
                // Count_Packs
                let countPacks = $(".Count_Pack").map(function() {
                    return $(this).val();
                }).get();

                let isNegative = false;
                countPacks.forEach(function(count) {
                    if (count <= 0) {
                        isNegative = true;
                        return isNegative;
                    }
                });
                if (isNegative) {
                    showToast(
                        "Số lượng gói hàng phải lớn hơn 0",
                        "bg-warning",
                        "fa-exclamation-circle"
                    );
                } else {
                    let order = {
                        Id_Order: $("input[name='Id_Order']").val(),
                        FK_Id_Customer: $("#FK_Id_Customer").val(),
                        Date_Order: $("#Date_Order").val(),
                        Date_Delivery: $("#Date_Delivery").val(),
                        Date_Reception: $("#Date_Reception").val(),
                        Note: $("#Note").val()
                    };
                    if (idContentPacks.length > 0) {
                        $.ajax({
                            url: "/wares/checkAmountContentPack",
                            type: "post",
                            data: {
                                id: order.Id_Order,
                                idContentPacks: idContentPacks,
                                countPacks: countPacks,
                                _token: token,
                            },
                            success: function(response) {
                                if (response.flag == true) {
                                    showToast(
                                        "Số lượng gói lấy vượt quá số lượng có sẵn trong kho",
                                        "bg-warning",
                                        "fa-exclamation-circle"
                                    );
                                } else {
                                    $.ajax({
                                        url: "/orders/update",
                                        type: "post",
                                        data: {
                                            formData: order,
                                            id: order.Id_Order,
                                            SimpleOrPack: 1,
                                            _token: token,
                                        },
                                        success: function(response) {
                                            let secondUrl =
                                                "/orders/packs/update";
                                            $.ajax({
                                                url: secondUrl,
                                                type: "post",
                                                data: {
                                                    id: order.Id_Order,
                                                    idContentPacks: idContentPacks,
                                                    countPacks: countPacks,
                                                    _token: token,
                                                },
                                                success: function(response) {window.location.href = response.url;
                                                },
                                                error: function(xhr) {
                                                    console.log(xhr.responseText);
                                                    alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                                                },
                                            });
                                        },
                                        error: function(xhr) {
                                            console.log(xhr.responseText);
                                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                                        },
                                    });
                                }
                            },
                            error: function(xhr) {
                                // Xử lý lỗi khi gửi yêu cầu Ajax
                                console.log(xhr.responseText);
                                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                            },
                        });
                    } else {
                        window.location.href = "/orders/packs";
                    }
                }
            }
        });
    });
</script>
@endpush
