@extends('layouts.master')

@section('title', 'Thêm thùng hàng vào gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Sửa thùng hàng</h4>
          </div>
          <h1>{{ session('count') }}</h1>
          <div class="card-body">
            {{-- <input type="hidden" name="FK_Id_Order" value="{{ $_GET['id'] }}">
            <form method="POST" id="formProduct">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_RawMaterial" style="width: 130px;">
                      Nguyên vật liệu
                    </label>
                    <select name="FK_Id_RawMaterial" id="FK_Id_RawMaterial" class="form-select">
                      @foreach ($materials as $each)
                      <option value="{{ $each->Id_RawMaterial }}" data-name="{{ $each->Name_RawMaterial }}">
                        {{ $each->Name_RawMaterial }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3 align-items-center ">
                    <label class="input-group-text bg-secondary-subtle" for="Count_RawMaterial">
                      Số lượng nguyên vật liệu
                    </label>
                    <input type="number" name="Count_RawMaterial" id="Count_RawMaterial" class="form-control" min="1"
                      value='1'>
                    <p data-name="unit" class="m-0 ps-3"></p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="FK_ID_ContainerType" style="width: 130px;">
                      Thùng chứa
                    </label>
                    <select class="form-select selectValidate" name="FK_ID_ContainerType" id="FK_ID_ContainerType">
                      @foreach ($containers as $each)
                      <option value="{{ $each->Id_ContainerType }}" data-name="{{ $each->Name_ContainerType }}">
                        {{ $each->Name_ContainerType }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Count_Container">
                      Số lượng thùng chứa
                    </label>
                    <input type="number" name="Count_Container" id="Count_Container" class="form-control" min="1"
                      value='1'>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Price_Container">
                      Đơn giá
                    </label>
                    <input type="number" name="Price_Container" id="Price_Container" class="form-control" min="1"
                      value='1'>
                  </div>
                </div>
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary-color mb-3 px-5">
                    <i class="fa-solid fa-plus text-white"></i>
                    Thêm sản phẩm
                  </button>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <label class="input-group-text bg-secondary-subtle" for="Count_Pack">
                      Số lượng gói hàng
                    </label>
                    <input type="number" name="Count_Pack" id="Count_Pack" class="form-control" min="1" value='1'>
                  </div>
                </div>
            </form> --}}
            <table class="table table-bordered">
              <thead>
                <tr>
                  {{-- <th scope="col" class="text-center align-middle col-md-1">Mã thùng</th> --}}
                  <th scope="col" class="align-middle text-center col-md-2">Nguyên liệu</th>
                  <th class="text-center align-middle " scope="col">Số lượng nguyên liệu</th>
                  <th class="text-center align-middle" scope="col">Đơn vị</th>
                  <th class="text-center align-middle" scope="col">Thùng chứa</th>
                  <th class="text-center align-middle " scope="col">Số lượng thùng chứa</th>
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
                        <option value="{{ $containerType->Id_ContainerType }}" @if ($containerType->Id_ContainerType ==
                          $simpleContent->FK_Id_ContainerType) selected @endif>
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
<script src="{{ asset('js/packs/createPack.js') }}"></script>
<script src="{{ asset('js/eventHandler.js') }}"></script> --}}
<script type="text/javascript">
  $(document).ready(function () {

    $('.btnDeleteSimple').click(function () {
      let Id_SimpleContent = $(this).data('id');
      let Id_PackContent = @json($Id_PackContent);
      // console.log(Id_SimpleContent);
      // console.log(@json($Id_PackContent));
      $.ajax({
        method: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          Id_SimpleContent: Id_SimpleContent,
          Id_PackContent: Id_PackContent
        },
        url: "/packs/deleteSimpleContent/" + Id_SimpleContent,
        success: function (data) {
          window.location.href = data.url;
          // console.log(data);
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
      // IdPackContent
      let idPackContent = @json($Id_PackContent);
      // IdSimpleContents
      let idSimpleContents = getValueIntoArr($(".Id_SimpleContent"));
      // FK_Id_RawMaterials
      let fkIdRawMaterials = getValueIntoArr($(".Id_RawMaterial"))
      // Count_RawMaterials
      let countRawMaterials = getValueIntoArr($(".Count_RawMaterial"));
      // FK_Id_ContainerTypes
      let fkIdContainerTypes = getValueIntoArr($(".Id_ContainerType"));
      // Count_Container
      let countContainers = getValueIntoArr($(".Count_Container"));
      // Price_Container
      let priceContainers = getValueIntoArr($(".Price_Container"));
      // console.log(priceContainer);
      $.ajax({
        url: '/simples/updateSimpleContent',
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
          window.location.href = response.url;
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