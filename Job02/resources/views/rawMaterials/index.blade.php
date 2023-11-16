@extends('layouts.master')

@section('title', 'Quản lý nguyên liệu thô')


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header px-0 pt-0 overflow-hidden">
          <h3 class="card-title bg-secondary-subtle p-3 text-primary-color">Quản lý nguyên liệu thô</h3>
          <a href="{{ route('rawMaterials.create')}}" class="btn btn-primary-color text-white p-2 my-3 ms-3">
            Thêm đơn nguyên liệu thô
          </a>
        </div>
        <div class="card-body px-0">
          <div class="ms-3 my-3" style="width: 300px;">
            <label for="FK_Id_RawMaterialType" class="form-label">Chọn loại nguyên liệu</label>
            <select name="FK_Id_RawMaterialType" class="form-select">
              @foreach($types as $each)
              <option value="{{ $each->id }}">{{ $each->name }}</option>
              @endforeach
            </select>
          </div>
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">Mã nguyên liệu</th>
                <th scope="col">Tên nguyên liệu</th>
                <th class="text-center" scope="col">Đơn vị</th>
                <th class="text-center" scope="col">Số lượng</th>
                <th class="text-center" scope="col">Hành động</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@if(session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class=" d-flex justify-content-center align-items-center gap-2">
        @if(session('type') == 'success')
        <i class="fas fa-check-circle text-light fs-5"></i>
        @elseif(session('type') == 'danger' || session('type') == 'warning')
        <i class="fas fa-xmark-circle text-light fs-5"></i>
        @elseif(session('type') == 'info' || session('type') == 'secondary')
        <i class="fas fa-info-circle text-light fs-5"></i>
        @endif
        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
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

  $(selectElement).on('change', function () {
    let id = $(this).val();
    let token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "{{ route('showMaterials') }}",
      method: 'POST',
      dataType: 'json',
      data: {
        id: id,
        _token: token
      },
      success: function (response) {
        let data = response.data;
        $("#table-data").empty(); // Làm rỗng phần tử HTML có id "table-data"
        $.each(data, function (key, value) {
          let id = value.Id_RawMaterial;
          let materialName = value.Name_RawMaterial;
          let unit = value.Unit;
          let count = value.count;
          let showUrl = "{{ route('rawMaterials.show', ':id') }}".replace(':id', id);
          let editUrl = "{{ route('rawMaterials.edit', ':id') }}".replace(':id', id);
          let deleteModalId = "deleteModal-" + id;
          let deleteUrl = "{{ route('rawMaterials.destroy', ':id') }}".replace(':id', id);

          let htmls =
            `<tr>
                <th class="text-center" scope="row">${id}</th>
                <td>${materialName}</td>
                <td class="text-center">${unit}</td>
                <td class="text-center">${count}</td>
                <td class="text-center">
                  <a href="${showUrl}" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="${editUrl}" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#${deleteModalId}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="${deleteModalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc xóa nguyên liệu thô này?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
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