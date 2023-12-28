@extends('layouts.master')

@section('title', 'Theo dõi đơn hàng')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Theo dõi đơn hàng</li>
        </ol>
      </nav>
      <div class="card">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Theo dõi đơn hàng</h4>
          <div class="row p-3">
            <div class="col-md-5">
              <div class="input-group">
                <label class="input-group-text bg-secondary-subtle" for="After_DateOrder">Ngày đặt hàng (Từ
                  ngày)</label>
                <input type="date" class="form-control" name="After_DateOrder" id="After_DateOrder"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
              <span class="form-message text-danger"></span>
            </div>
            <div class="col-md-5">
              <div class="input-group">
                <label class="input-group-text bg-secondary-subtle" for="Before_DateOrder">Ngày đặt hàng (Đến
                  ngày)</label>
                <input type="date" class="form-control" name="Before_DateOrder" id="Before_DateOrder"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                </select>
              </div>
              <span class="form-message text-danger"></span>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary-color px-3" id="searchBtn">
                <i class="fa-solid fa-search text-white me-2"></i>Tìm kiếm
              </button>
            </div>
          </div>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped">
            <thead class="text-center">
              <tr class="text-center">
                <th scope="col">Mã đơn hàng</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Ngày đặt hàng</th>
                <th scope="col">Ngày giao hàng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Trạng thái sản phẩm</th>
                <th scope="col">Kiểu hàng</th>
                <th scope="col">Xem</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider text-center">
            </tbody>
          </table>
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
<script src="{{ asset('js/app.js') }}"></script>
<script>
  $(document).ready(function () {
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();

    let token = $('meta[name="csrf-token"]').attr("content");
    let firstControl = $("#After_DateOrder");
    let secondControl = $("#Before_DateOrder");

    $("#searchBtn").on('click', function (event) {
      if (secondControl.val() < firstControl.val()) {
        secondControl.parent().next().html("Vui lòng chọn ngày phù hợp");
        firstControl.parent().next().html("Vui lòng chọn ngày phù hợp");
        secondControl.addClass("is-invalid");
        firstControl.addClass("is-invalid");
      }
      else {
        secondControl.parent().next().html("");
        firstControl.parent().next().html("");
        secondControl.removeClass("is-invalid");
        firstControl.removeClass("is-invalid");
      }
      $.ajax({
        url: '/tracking/orders/ShowOrderByDate',
        type: "post",
        data: {
          dateAfter: firstControl.val(),  // Corrected here
          dateBefore: secondControl.val(),  // Corrected here
          _token: token,
        },
        success: function (response) {
          console.log(response);
          let table = $("#table-data");
          table.html("");
          $.each(response.data, function (key, value) {
            let id = value.Id_Order;
            let route =
              value.SimpleOrPack == 1
                ? `/tracking/showPacks/${id}`
                : `/tracking/showSimples/${id}`;
            let progress = value.progress;
            let status = value.status;
            html = `<tr class="text-center align-middle">
                  <td>${id}</td>
                  <td>${value.Name_Customer}</td>
                  <td>${value.Date_Order != null ? formatDate(value.Date_Order) : 'Chưa giao hàng'}</td>
                  <td>${value.Date_Delivery != null ? formatDate(value.Date_Delivery) : 'Chưa giao hàng'}</td>
                  <td>${status}</td>
                  <td>
                    <div class="d-flex justify-content-center">
                      <div class="progress w-50 position-relative" role="progressbar" aria-valuenow="${progress}" aria-valuemin="0"
                        aria-valuemax="100" style="height: 20px">
                        <div class="progress-bar bg-primary-color" style="width: ${progress}%">
                        </div>
                        <span class="progress-text fw-bold fs-6 ${progress > 35 ? 'text-white' : 'text-primary-color'}">${progress}%</span>
                      </div>
                    </div>
                  </td>
                  <td>${value.SimpleOrPack == 1 ? 'Gói hàng' : 'Thùng hàng'}</td>
                  <td>
                    <a href="${route}" class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </td>
                </tr>`;
            table.append(html);
          });
        },
        error: function (xhr) {
          console.log(xhr.responseText);
          alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
        },
      });
    });
  });
</script>
@endpush