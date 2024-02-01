@extends('layouts.master')

@section('title', 'Tạo gói hàng')

@section('content')
<div class="row g-0 p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="h4 m-0 fw-bold text-body-secondary">Tạo đơn gói hàng</h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
      <li class="breadcrumb-item">
        <a class="text-decoration-none" href="{{ route('orders.packs.index') }}">Quản lý đơn gói hàng</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">Thêm</li>
    </ol>
  </div>
</div>
<div class="row g-0 p-3">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin chung</h5>
      </div>
      <div class="card-body">
        <form method="POST" id="formInformation">
          @csrf
          <input type="hidden" name="count" value="{{ isset($count) ? 1 : 0 }}">
          <input type="hidden" name="SimpleOrPack" value="1">
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" for="FK_Id_Customer" style="width: 140px;">Khách
                      hàng</label>
                    <select class="form-select selectValidate" id="FK_Id_Customer" name="FK_Id_Customer">
                      @foreach ($customers as $each)
                      @if (isset($information))
                      @if ($information->FK_Id_Customer == $each->Id_Customer)
                      <option value="{{ $each->Id_Customer }}" selected>{{ $each->Name_Customer }}</option>
                      @else
                      <option value="{{ $each->Id_Customer }}" disabled>{{ $each->Name_Customer }}</option>
                      @endif
                      @else
                      <option value="{{ $each->Id_Customer }}">{{ $each->Name_Customer }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <span class="form-message text-danger"></span>
                </div>
                <div class="col-md-12">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" style="width: 140px;">Ngày đặt hàng</label>
                    <input type="date" class="form-control" id="Date_Order" name="Date_Order" {{ isset($information)
                      ? "readonly" : '' }} value="{{ isset($information) 
                      ? \Carbon\Carbon::parse($information->Date_Order)->format('Y-m-d') 
                      : \Carbon\Carbon::now()->format('Y-m-d') }}">
                  </div>
                  <span class="form-message text-danger"></span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" style="width: 140px;">
                      Ngày giao hàng
                    </label>
                    <input type="date" class="form-control" id="Date_Delivery" name="Date_Delivery" {{
                      isset($information) ? "readonly" : '' }} value="{{ isset($information) 
                        ? \Carbon\Carbon::parse($information->Date_Delivery)->format('Y-m-d') 
                        : \Carbon\Carbon::now()->format('Y-m-d') }}">
                  </div>
                  <span class="form-message text-danger"></span>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="input-group">
                    <label class="input-group-text bg-secondary-subtle" style="width: 140px;">
                      Ngày nhận hàng
                    </label>
                    <input type="date" class="form-control" id="Date_Reception" name="Date_Reception" {{
                      isset($information) ? "readonly" : '' }} value="{{ isset($information) 
                      ? \Carbon\Carbon::parse($information->Date_Reception)->format('Y-m-d') 
                      : \Carbon\Carbon::now()->format('Y-m-d') }}">
                  </div>
                  <span class="form-message text-danger"></span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text bg-secondary-subtle">Ghi chú</span>
                <textarea class="form-control" style="height: 91px;" aria-label="Notes" name="Note" {{
                  isset($information) ? "readonly" : '' }}
                  rows="5">{{ isset($information) ? $information->Note : '' }}</textarea>
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
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-header border-0 bg-white">
        <h4 class="card-title m-0 fw-bold text-body-secondary">Thông tin gói hàng</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-primary px-5" id="addBtn">
            <i class="fa-solid fa-plus text-white me-2"></i>Thêm gói hàng
          </button>
          <button type="submit" class="btn btn-primary px-5" id="redirectBtn">
            <i class="fa-solid fa-warehouse me-2"></i> Lấy gói hàng từ trong kho
          </button>
        </div>
        <table class="table mt-4">
          <thead class="table-light">
            <tr>
              <th scope="col" class="py-3 text-center">#</th>
              <th scope="col" class="py-3 text-center">Số lượng</th>
              <th scope="col" class="py-3 text-center">Đơn giá</th>
              <th scope="col" class="py-3 text-center">Trạng thái</th>
              <th scope="col" class="py-3 text-center">Hoạt động</th>
            </tr>
          </thead>
          <tbody id="table-data">
            @if (isset($data))
            @foreach ($data as $each)
            <tr data-id="{{ $each->Id_ContentPack }}">
              <td class="text-center">{{ $each->Id_ContentPack }}</td>
              <td class="text-center">{{ $each->Count_Pack }} gói hàng</td>
              <td class="text-center">
                {{ number_format($each->Price_Pack, 0, ',', '.') . ' VNĐ' }}
              </td>
              <td class="text-center">{{ $each->Status }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm text-secondary" data-bs-toggle="modal"
                  data-bs-target="#deleteID-{{ $each->Id_ContentPack }}">
                  <i class="fa-solid fa-trash"></i>
                </button>
                <div class="modal fade" id="deleteID-{{ $each->Id_ContentPack }}" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Bạn có chắc chắn về việc sản phẩm này
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary btnDelete"
                          data-id="{{ $each->Id_ContentPack }}">Xóa</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="d-flex align-items-center justify-content-end gap-3">
          <button class="btn btn-light" id="backBtn">Quay
            lại</button>
          <a href="{{ route('orders.packs.index') }}" class="btn btn-primary">Lưu</a>
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
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('javascript')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/orders/packs/create.js') }}"></script>
<script>
  $(document).ready(function () {
    let token = $('meta[name="csrf-token"]').attr("content");
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

    function showToast(message, bgColorClass, iconClass) {
      $(".toast-body").addClass(bgColorClass);
      $("#icon").addClass(iconClass);
      $("#toast-msg").html(message);
      toastBootstrap.show();

      setTimeout(() => {
        toastBootstrap.hide();
        setTimeout(() => {
          $(".toast-body").removeClass(bgColorClass);
          $("#icon").removeClass(iconClass);
          $("#toast-msg").html();
        }, 1000);
      }, 5000);
    }

    $(document).on("click", ".btnDelete", function () {
      let id = $(this).data("id");
      let modalElement = $("#deleteID-" + id);
      let rowElement = $(this).closest('tr[data-id="' + id + '"]');
      $.ajax({
        url: "/orders/packs/deletePacks",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          _token: token,
        },
        success: function (response) {
          modalElement.on("hidden.bs.modal", function () {
            rowElement.remove();
          });

          // Đóng modal
          modalElement.modal("hide");
          showToast(
            "Xóa gói hàng thành công",
            "bg-success",
            "fa-check-circle"
          );
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    });

    $("#backBtn").on('click', function () {
      let urlParams = new URLSearchParams(window.location.search);
      let id = urlParams.get("id");
      $.ajax({
        url: "/orders/packs/destroyPacksWhenBack",
        method: "POST",
        dataType: "json",
        data: {
          id: id,
          _token: token,
        },
        success: function (response) {
          window.location.href = "{{ route('orders.packs.index') }}"
        },
        error: function (xhr) {
          // Xử lý lỗi khi gửi yêu cầu Ajax
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    })
  })
</script>
@endpush