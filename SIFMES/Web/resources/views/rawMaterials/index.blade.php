@extends('layouts.master')

@section('title', 'Quản lý nguyên liệu thô')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý nguyên liệu thô</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Quản lý nguyên liệu thô
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('rawMaterials.create') }}" class="btn btn-main">
                            <i class="fa-solid fa-plus text-white me-1 fs-6"></i>
                            <span>Thêm nguyên liệu thô</span>
                        </a>
                        <div class="d-flex align-items-center">
                            <label class="form-label mb-0 me-2 text-nowrap" for="FK_Id_RawMaterialType">
                                Chọn loại nguyên liệu
                            </label>
                            <select class="form-select" name="FK_Id_RawMaterialType">
                                @foreach ($types as $each)
                                    <option value="{{ $each->id }}">{{ $each->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-heading">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Tên nguyên liệu</th>
                                <th scope="col" class="py-2">Loại nguyên liệu</th>
                                <th scope="col" class="py-2">Đơn vị</th>
                                <th scope="col" class="py-2 text-center">Số lượng</th>
                                <th scope="col" class="py-2 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
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
    <script>
        const toastLiveExample = $('#liveToast');
        const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
        toastBootstrap.show();
        let selectElement = $("select[name='FK_Id_RawMaterialType']");

        $(selectElement).on('change', function() {
            let id = $(this).val();
            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('rawMaterials.showMaterials') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _token: token
                },
                success: function(response) {
                    let data = response.data;
                    $("#table-data").empty(); // Làm rỗng phần tử HTML có id "table-data"
                    $.each(data, function(key, value) {
                        let id = value.Id_RawMaterial;
                        let materialName = value.Name_RawMaterial;
                        let materialTypeName = value.Name_RawMaterialType;
                        let unit = value.Unit;
                        let count = value.count;
                        let editUrl = "{{ route('rawMaterials.edit', ':id') }}".replace(':id',
                            id);
                        let deleteModalId = "deleteModal-" + id;
                        let deleteUrl = "{{ route('rawMaterials.destroy', ':id') }}".replace(
                            ':id', id);

                        let htmls =
                            `<tr class="align-middle">
                                <th scope="row" class="text-center text-body-secondary">${id}</th>
                                    <td>${materialName}</td>
                                    <td class="align-middle">
                                        <span class="badge badge-main fw-normal fs-6">${materialTypeName}</span>
                                    </td>
                                    <td>${unit.charAt(0).toUpperCase() + unit.slice(1)}</td>
                                    <td class="text-center">${count}</td>
                                    <td class="text-center align-middle">
                                    <a href="${editUrl}" class="btn btn-sm btn-outline">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#${deleteModalId}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <div class="modal fade" id="${deleteModalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="m-0">Bạn chắc chắn muốn xóa nguyên liệu thô này?</p>
                                                        <p class="m-0">
                                                            Việc này sẽ xóa nguyên liệu thô vĩnh viễn. <br>
                                                            Hãy chắc chắn trước khi tiếp tục.
                                                        </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <form action="${deleteUrl}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Xác nhận</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>`;
                        $("#table-data").append(htmls);
                    });
                }
            });
        });

        var firstOptionValue = $(selectElement).val();

        // Gán giá trị cho phần tử select
        $(selectElement).val(firstOptionValue);

        // Gọi sự kiện change để hiển thị dữ liệu
        $(selectElement).change();
    </script>
@endpush
