@extends('layouts.master')

@section('title', 'Sửa thùng hàng trong gói hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('orders.packs.edit', $Id_Order) }}">
                    Sửa gói hàng
                </a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa thùng hàng trong gói hàng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">Sửa thùng hàng trong gói hàng</h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin thùng hàng</h5>
                    <table class="table table-borderless m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center text-truncate">Nguyên liệu</th>
                                <th scope="col" class="py-2 text-center text-truncate">Số lượng nguyên liệu</th>
                                <th scope="col" class="py-2 text-center text-truncate">Đơn vị</th>
                                <th scope="col" class="py-2 text-center text-truncate">Thùng chứa</th>
                                <th scope="col" class="py-2 text-center text-truncate">Số lượng thùng chứa</th>
                                <th scope="col" class="py-2 text-center text-truncate">Đơn giá</th>
                                <th scope="col" class="py-2 text-center text-truncate"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ContentSimples as $ContentSimple)
                                <tr class="align-middle">
                                    <form action="" method="POST">
                                        <input class="Id_ContentSimple" type="hidden"
                                            value="{{ $ContentSimple->Id_ContentSimple }}">
                                        <td class="text-center">
                                            <select class="form-select Id_RawMaterial">
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->Id_RawMaterial }}"
                                                        @if ($material->Id_RawMaterial === $ContentSimple->material->Id_RawMaterial) selected @endif>
                                                        {{ $material->Name_RawMaterial }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="form-control Count_RawMaterial"
                                                value="{{ $ContentSimple->Count_RawMaterial }}" min="1">
                                        </td>
                                        <td class="text-center RawMaterial_Unit">{{ $ContentSimple->material->Unit }}</td>
                                        <td class="text-center">
                                            <select class="form-select Id_ContainerType">
                                                @foreach ($containerTypes as $containerType)
                                                    <option @if ($containerType->Id_ContainerType == $ContentSimple->FK_Id_ContainerType) selected @endif
                                                        value="{{ $containerType->Id_ContainerType }}">
                                                        {{ $containerType->Name_ContainerType }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="form-control Count_Container"
                                                value="{{ $ContentSimple->Count_Container }}" min="1">
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="form-control Price_Container"
                                                value="{{ $ContentSimple->Price_Container }}">
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal"
                                                data-bs-target="#deleteID-{{ $ContentSimple->Id_ContentSimple }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="deleteID-{{ $ContentSimple->Id_ContentSimple }}"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-0">Bạn chắc chắn muốn thùng hàng này?</p>
                                                            <p class="m-0">
                                                                Việc này sẽ thùng hàng vĩnh viễn. <br>
                                                                Hãy chắc chắn trước khi tiếp tục.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Hủy</button>
                                                            <button type="button" class="btn btn-danger btnDeleteSimple"
                                                                data-id="{{ $ContentSimple->Id_ContentSimple }}">Xác
                                                                nhận</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <a class="btn btn-secondary" href="{{ route('orders.packs.edit', $Id_Order) }}" id="backBtn">
                            Quay lại
                        </a>
                        <button type="button" class="btn btn-primary" id="saveBtn">Lưu</button>
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
        $(document).ready(function() {
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

            let token = $('meta[name="csrf-token"]').attr("content");
            $(".btnDeleteSimple").on('click', function() {
                let Id_ContentSimple = $(this).data('id');
                let Id_ContentPack = @json($Id_ContentPack);
                let rowElement = $(this).closest('tr');
                let modalElement = $("#deleteID-" + Id_ContentSimple);
                $.ajax({
                    method: 'POST',
                    data: {
                        _token: token,
                        Id_ContentSimple: Id_ContentSimple,
                    },
                    url: "/orders/simples/checkSimpleInProcess",
                    success: function(response) {
                        if (response.flag == 1) {
                            showToast(
                                "Thùng hàng đang trong quá trình sản xuất, không thể xóa!",
                                "bg-warning", "fa-exclamation-circle");
                        } else {
                            $.ajax({
                                method: 'POST',
                                data: {
                                    _token: token,
                                    Id_ContentSimple: Id_ContentSimple,
                                    Id_ContentPack: Id_ContentPack
                                },
                                url: "/orders/packs/destroySimpleInPack/" +
                                    Id_ContentSimple,
                                success: function(data) {
                                    modalElement.on("hidden.bs.modal", function() {
                                        showToast(
                                            "Xóa thùng hàng thành công",
                                            "bg-success",
                                            "fa-check-circle"
                                        );
                                        rowElement.remove();
                                    });

                                    modalElement.modal("hide");
                                },
                                error: function(xhr) {
                                    // Xử lý lỗi khi gửi yêu cầu Ajax
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
            })

            // Sự kiện thay đổi nguyên liệu thì đơn vị thay đổi
            $(".Id_RawMaterial").on('change', function() {
                let Id_RawMaterial = $(this).val();
                let rowNumber = $(this).closest('tr').index();
                let materials = @json($materials);

                let unit = materials[Id_RawMaterial]['Unit'];
                $(".RawMaterial_Unit").eq(rowNumber).html(unit);
            });

            // Sự kiện lưu gói hàng 
            $("#saveBtn").on('click', function() {
                let isValid = true;
                $(".table .form-control").each(function() {
                    if ($(this).val() == "") {
                        $(this).addClass("is-invalid");
                        isValid = false;
                    }
                })

                if (isValid) {
                    let idContentPack = @json($Id_ContentPack);
                    let idContentSimples = getValueIntoArr($(".Id_ContentSimple"));
                    let fkIdRawMaterials = getValueIntoArr($(".Id_RawMaterial"))
                    let countRawMaterials = getValueIntoArr($(".Count_RawMaterial"));
                    let fkIdContainerTypes = getValueIntoArr($(".Id_ContainerType"));
                    let countContainers = getValueIntoArr($(".Count_Container"));
                    let priceContainers = getValueIntoArr($(".Price_Container"));
                    $.ajax({
                        url: '/orders/packs/updateSimpleInPack',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            idContentPack: idContentPack,
                            idContentSimples: idContentSimples,
                            fkIdRawMaterials: fkIdRawMaterials,
                            countRawMaterials: countRawMaterials,
                            fkIdContainerTypes: fkIdContainerTypes,
                            countContainers: countContainers,
                            priceContainers: priceContainers
                        },
                        success: function(response) {
                            window.location.href = response.url
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                }
            });
        });

        function getValueIntoArr(name) {
            let arr = name.map(function() {
                return $(this).val();
            }).get();
            return arr;
        }

        let tdElements = $("td");
        tdElements.filter(function() {
            return !$(this).children().is('[tabIndex]');
        }).each(function(index) {
            $(this).children().attr("tabIndex", index);
        });
        $("#saveBtn").attr("tabIndex", tdElements.length);
        $("#backBtn").attr("tabIndex", tdElements.length + 1);
    </script>
@endpush
