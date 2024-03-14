@extends('layouts.master')

@section('title', 'Quản lý nguyên liệu thô')

@section('content')
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="h4 m-0 fw-bold text-body-secondary">Quản lý nguyên liệu thô</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý nguyên liệu thô</li>
            </ol>
        </div>
    </div>
    <div class="row g-0 p-3 pt-0">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('rawMaterials.create') }}" class="btn btn-danger rounded-1">
                            <i class="fa-solid fa-plus text-white me-3 fs-6"></i>
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
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Tên nguyên liệu</th>
                                <th scope="col" class="py-3">Loại nguyên liệu</th>
                                <th scope="col" class="py-3">Đơn vị</th>
                                <th scope="col" class="py-3 text-center">Số lượng</th>
                                <th scope="col" class="py-3 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-end">
                    <a href="{{ route('index') }}" class="btn btn-light">Quay lại</a>
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
                        let showUrl = "{{ route('rawMaterials.show', ':id') }}".replace(':id',
                            id);
                        let editUrl = "{{ route('rawMaterials.edit', ':id') }}".replace(':id',
                            id);
                        let deleteModalId = "deleteModal-" + id;
                        let deleteUrl = "{{ route('rawMaterials.destroy', ':id') }}".replace(
                            ':id', id);

                        let htmls =
                            `<tr>
                <th scope="row" class="text-center text-body-secondary">${id}</th>
                <td>${materialName}</td>
                <td>
                  <span class="badge text-bg-primary fw-normal fs-6">${materialTypeName}</span>
                </td>
                <td>${unit.charAt(0).toUpperCase() + unit.slice(1)}</td>
                <td class="text-center">${count}</td>
                <td class="text-center">
                  <a href="${showUrl}" class="btn btn-sm text-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="${editUrl}" class="btn btn-sm text-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#${deleteModalId}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="${deleteModalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title fw-bold text-secondary" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc xóa nguyên liệu thô này?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                          <form action="${deleteUrl}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
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
