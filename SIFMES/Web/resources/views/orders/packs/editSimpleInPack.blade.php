@extends('layouts.master')

@section('title', 'Sửa thùng hàng trong gói hàng')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Sửa thùng hàng trong gói hàng</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('orders.packs.edit', $Id_Order) }}">
                        Sửa
                    </a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa thùng hàng trong gói hàng</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center col-md-2">Nguyên liệu</th>
                                <th scope="col" class="py-3 text-center">Số lượng nguyên liệu</th>
                                <th scope="col" class="py-3 text-center">Đơn vị</th>
                                <th scope="col" class="py-3 text-center">Thùng chứa</th>
                                <th scope="col" class="py-3 text-center">Số lượng thùng chứa</th>
                                <th scope="col" class="py-3 text-center">Đơn giá</th>
                                <th scope="col" class="py-3 text-center">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ContentSimples as $ContentSimple)
                                <tr>
                                    <form action="" method="POST">
                                        <input class="Id_ContentSimple" type="hidden"
                                            value="{{ $ContentSimple->Id_ContentSimple }}">
                                        <td class="align-middle ">
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
                                                value="{{ $ContentSimple->Count_RawMaterial }}" min='1'>
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
                                                value="{{ $ContentSimple->Count_Container }}" min='1'>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="form-control Price_Container"
                                                value="{{ $ContentSimple->Price_Container }}" min='1'>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal"
                                                data-bs-target="#deleteID-{{ $ContentSimple->Id_ContentSimple }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="deleteID-{{ $ContentSimple->Id_ContentSimple }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fw-bold text-secondary"
                                                                id="exampleModalLabel">Xác nhận</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn có chắc chắn về việc xóa thùng hàng này
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Hủy</button>
                                                            <button type="button" class="btn btn-danger btnDeleteSimple"
                                                                data-id="{{ $ContentSimple->Id_ContentSimple }}">Xóa</button>
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
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <a class="btn btn-light" href="{{ route('orders.packs.edit', $Id_Order) }}">
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
    {{--
<script src="{{ asset('js/orders/packs/create.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
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

            let token = $('meta[name="csrf-token"]').attr("content");

            $('.btnDeleteSimple').click(function() {
                let Id_ContentSimple = $(this).data('id');
                let Id_ContentPack = @json($Id_ContentPack);
                $.ajax({
                    method: 'POST',
                    data: {
                        _token: token,
                        Id_ContentSimple: Id_ContentSimple,
                    },
                    url: "/orders/simples/checkSimpleInProcess",
                    success: function(response) {
                        if (response == 1) {
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
                                    window.location.href = data.url;
                                }
                            });
                        } else {
                            showToast(
                                "Thùng hàng đang trong quá trình sản xuất, không thể xóa!",
                                "bg-warning", "fa-exclamation-circle");
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
                    }
                });
            });
        });

        function getValueIntoArr(name) {
            let arr = name.map(function() {
                return $(this).val();
            }).get();
            return arr;
        }
    </script>
@endpush