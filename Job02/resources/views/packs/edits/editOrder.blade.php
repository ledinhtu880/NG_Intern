@extends('layouts.master')

@section('title', 'Sửa gói hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">
              <a class="text-decoration-none" href="{{ route('packs.index') }}">Quản lý đơn gói hàng</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Sửa gói hàng</li>
          </ol>
        </nav>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin chung</h4>
          </div>
          <div class="card-body">
            <form method="POST" id="formInformation">
              @csrf
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" for="FK_Id_Customer"
                          style="width: 130px;">Khách hàng</label>
                        <select class="form-select selectValidate" id="FK_Id_Customer" name="FK_Id_Customer">
                          @foreach ($customers as $each)
                          <option value="{{ $each->Id_Customer }}" @if ($order->FK_Id_Customer == $each->Id_Customer)
                            selected @endif>
                            {{ $each->Name_Customer }}</option>
                          @endforeach
                        </select>
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-12">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 130px;">Ngày đặt hàng</label>
                        <input type="date" class="form-control" id="Date_Order" name="Date_Order"
                          value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Order)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Order)->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                          Ngày giao hàng
                        </label>
                        <input type="date" class="form-control" id="Date_Dilivery" name="Date_Dilivery"
                          value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Dilivery)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Dilivery)->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="input-group">
                        <label class="input-group-text bg-secondary-subtle" style="width: 135px;">
                          Ngày nhận hàng
                        </label>
                        <input type="date" class="form-control" id="Date_Reception" name="Date_Reception"
                          value="{{ isset($information) ? \Carbon\Carbon::parse($information->Date_Reception)->format('Y-m-d') : \Carbon\Carbon::parse($order->Date_Reception)->format('Y-m-d') }}">
                      </div>
                      <span class="form-message text-danger"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-text bg-secondary-subtle">Ghi chú</span>
                    <textarea class="form-control" id="Note" style="height: 91px;" aria-label="Notes" name="Note"
                      rows="5">{{ isset($information) ? $information->Note : '' }}</textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Thông tin gói hàng</h4>
          </div>
          <div class="card-body">
            <button type="submit" class="btn btn-primary-color px-5" id="addBtn">
              <i class="fa-solid fa-plus text-white me-2"></i>Thêm gói hàng
            </button>
          </div>
          <div class="card-footer p-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Mã gói hàng</th>
                  <th class="text-center col-md-2" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center">Hoạt động</th>
                </tr>
              </thead>
              <tbody id="table-data">
                @if (isset($contentPack))
                @foreach ($contentPack as $each)
                <tr data-id="{{ $each->Id_PackContent }}">
                  <form method="POST">
                    <td class="text-center align-middle ">
                      <span class="Id_PackContent">
                        {{ $each->Id_PackContent }}
                      </span>
                    </td>
                    <td class="text-center input-group">
                      <input type="number" class="form-control Count_Pack" id="Count_Pack"
                        value="{{ $each->Count_Pack }}" min="1" required>
                      <label for="Count_Pack" class="input-group-text">gói hàng</label>
                    </td>
                    <td class="text-center align-middle ">
                      {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}</td>
                    <td class="text-center align-middle ">
                      <a href="{{ route('packs.showFormEditSimple', ['Id_PackContent' => $each->Id_PackContent]) }}"
                        class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                        data-bs-toggle="modal" data-bs-target="#deleteID-{{ $each->Id_PackContent }}">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                      <div class="modal fade" id="deleteID-{{ $each->Id_PackContent }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Bạn có chắc chắn về việc sản phẩm này
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                              <button type="button" class="btn btn-danger deletePack"
                                data-id="{{ $each->Id_PackContent }}">Xóa</button>
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
        </div>
        <div class="d-flex align-items-center justify-content-end mt-3">
          <button class="btn btn-lg btn-primary-color px-4" id="btn_save">Lưu</button>
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
<script type="text/javascript">
  $(document).ready(function () {
    $("#addBtn").on("click", function () {
      let Id_Order = @json($order -> Id_Order);
      window.location.href = "/packs/createPack?id=" + Id_Order;
    });

    $(".deletePack").on('click', function () {
      let Id_PackContent = $(this).data('id');
      // console.log(Id_PackContent);
      $.ajax({
        url: '/packs/destroyPackContent',
        type: 'POST',
        data: {
          _token: $("meta[name='csrf-token']").attr('content'),
          idPackContent: Id_PackContent,
          idOrder: @json($order -> Id_Order)
        },
        success: function (response) {
          // console.log(response);
          window.location.href = response.url;
        }
      });
    })

    function getValueIntoArr(name) {
      let arr = name.map(function () {
        return $(this).val();
      }).get();
      return arr;
    }

    $("#btn_save").on('click', function () {
      // Id packcontent
      let idPackContents = $(".Id_PackContent").map(function () {
        return $(this).html();
      }).get();

      // Bỏ ký tự \n và khoảng cách thừa, chỉ lấy số
      idPackContents = idPackContents.map(function (element) {
        let res = $.trim(element);
        return res;
      })
      // Count_Packs
      let countPacks = $(".Count_Pack").map(function () {
        return $(this).val();
      }).get();

      // Thông tin hóa đơn mới cần sửa
      let order = {
        Id_Order: @json($order -> Id_Order),
        FK_Id_Customer: $("#FK_Id_Customer").val(),
        Date_Order: $("#Date_Order").val(),
        Date_Dilivery: $("#Date_Dilivery").val(),
        Date_Reception: $("#Date_Reception").val(),
        Note: $("#Note").val()
      };

      $.ajax({
        url: '/orders/updatePackAndCustomer',
        type: 'POST',
        data: {
          _token: $("meta[name='csrf-token']").attr('content'),
          order: order,
          idPackContents: idPackContents,
          countPacks: countPacks
        },
        success: function (response) {
          // console.log(response);
          window.location.href = response.url;
        }
      })
    });
  });
</script>
@endpush