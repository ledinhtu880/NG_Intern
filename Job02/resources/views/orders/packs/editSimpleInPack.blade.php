@extends('layouts.master')

@section('title', 'Sửa thùng hàng trong gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('orders.packs.edit', $Id_Order) }}">
                Sửa gói hàng
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa thùng hàng trong gói hàng</li>
          </ol>
        </nav>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Sửa thùng hàng trong gói hàng</h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col" class="align-middle text-center col-md-2">Nguyên liệu</th>
                  <th class="text-center align-middle" scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center align-middle" scope="col">Đơn vị</th>
                  <th class="text-center align-middle" scope="col">Thùng chứa</th>
                  <th class="text-center align-middle" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center align-middle" scope="col">Đơn giá</th>
                  <th class="text-center align-middle">Xóa</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($simpleContents as $simpleContent)
                <tr>
                  <form action="" method="POST">
                    <input class="Id_SimpleContent" type="hidden" value="{{ $simpleContent->Id_SimpleContent }}">
                    <td class="align-middle ">
                      <select class="form-select Id_RawMaterial">
                        @foreach ($materials as $material)
                        <option value="{{ $material->Id_RawMaterial }}" @if ($material->Id_RawMaterial ===
                          $simpleContent->material->Id_RawMaterial) selected @endif>
                          {{ $material->Name_RawMaterial }}
                        </option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-middle ">
                      <input type="number" class="form-control Count_RawMaterial"
                        value="{{ $simpleContent->Count_RawMaterial }}" min='1'>
                    </td>
                    <td class="align-middle text-center RawMaterial_Unit">{{ $simpleContent->material->Unit }}</td>
                    <td class="align-middle ">
                      <select class="form-select Id_ContainerType">
                        @foreach ($containerTypes as $containerType)
                        <option @if ($containerType->Id_ContainerType == $simpleContent->FK_Id_ContainerType) selected
                          @endif value="{{ $containerType->Id_ContainerType }}" >
                          {{ $containerType->Name_ContainerType }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-middle ">
                      <input type="number" class="form-control Count_Container"
                        value="{{ $simpleContent->Count_Container }}" min='1'>
                    </td>
                    <td class="align-middle ">
                      <input type="number" class="form-control Price_Container"
                        value="{{ $simpleContent->Price_Container }}" min='1'>
                    </td>
                    <td class="align-middle ">
                      <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                        data-bs-toggle="modal" data-bs-target="#deleteID-{{ $simpleContent->Id_SimpleContent }}">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                      <div class="modal fade" id="deleteID-{{ $simpleContent->Id_SimpleContent }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Bạn có chắc chắn về việc xóa thùng hàng này
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                              <button type="button" class="btn btn-danger btnDeleteSimple"
                                data-id="{{ $simpleContent->Id_SimpleContent }}">Xóa</button>
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
        </div>
        <div class="d-flex align-items-center justify-content-end my-3 me-3">
          <button type="button" class="btn btn-primary-color px-4" id="saveBtn">Lưu gói hàng</button>
        </div>
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
        <i class="fas fa-check-circle text-light fs-5">{{ session('message') }}</i>
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
{{--
<script src="{{ asset('js/orders/packs/create.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script> --}}
<script type="text/javascript">
  $(document).ready(function () {

    $('.btnDeleteSimple').click(function () {
      let Id_SimpleContent = $(this).data('id');
      let Id_PackContent = @json($Id_PackContent);
      $.ajax({
        method: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          Id_SimpleContent: Id_SimpleContent,
          Id_PackContent: Id_PackContent
        },
        url: "/orders/packs/destroySimpleInPack/" + Id_SimpleContent,
        success: function (data) {
          window.location.href = data.url;
        }
      });
    })

    // Sự kiện thay đổi nguyên liệu thì đơn vị thay đổi
    $(".Id_RawMaterial").on('change', function () {
      let Id_RawMaterial = $(this).val();
      let rowNumber = $(this).closest('tr').index();
      let materials = @json($materials);

      let unit = materials[Id_RawMaterial]['Unit'];
      $(".RawMaterial_Unit").eq(rowNumber).html(unit);
    });

    // Sự kiện lưu gói hàng
    $("#saveBtn").on('click', function () {
      let idPackContent = @json($Id_PackContent);
      let idSimpleContents = getValueIntoArr($(".Id_SimpleContent"));
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
          idPackContent: idPackContent,
          idSimpleContents: idSimpleContents,
          fkIdRawMaterials: fkIdRawMaterials,
          countRawMaterials: countRawMaterials,
          fkIdContainerTypes: fkIdContainerTypes,
          countContainers: countContainers,
          priceContainers: priceContainers
        },
        success: function (response) {
          window.location.href = response.url
        }
      });
    });
  });

  function getValueIntoArr(name) {
    let arr = name.map(function () {
      return $(this).val();
    }).get();
    return arr;
  }
</script>
@endpush