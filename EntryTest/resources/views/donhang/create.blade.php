@extends('layouts.master')

@section('title', 'Tạo đơn hàng')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex flex-column align-items-center justify-content-center">
      <div class="w-50 mt-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title m-0">Tạo đơn hàng mới</h3>
          </div>
          <div class="card-body">
            <form id="formAjax" method="POST">
              @csrf
              <div class="d-flex justify-content-between gap-5">
                <div class="form-group w-50">
                  <label class="form-label">Nhà cung cấp</label>
                  <select name="FK_Id_NCC" id="FK_Id_NCC" class="form-select">
                    @foreach($ncc as $each)
                    <option value="{{ $each->Id_NCC }}">
                      {{ $each->Ten_NCC }}
                    </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group w-50">
                  <label for="Ngay_DatHang" class="form-label">Ngày đặt hàng</label>
                  <input type="date" name="Ngay_DatHang" id="Ngay_DatHang" class="form-control"
                    placeholder="Nhập ngày đặt hàng" value="{{ date('Y-m-d') }}">
                  <span class="error-message text-danger"></span>
                </div>
              </div>
              <div class="d-flex justify-content-end my-4 gap-3">
                <a href="{{ route('index') }}" class="btn btn-warning">Quay lại</a>
                <button type="submit" class="btn btn-success">Tạo đơn</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="w-75 mt-3">
        <div class="card my-3">
          <div class="card-header">
            <h3 class="card-title m-0">Thêm chi tiết đơn hàng
            </h3>
          </div>
          <div class="card-body">
            <form id="myForm" method="POST">
              @csrf
              <input type="hidden" name="FK_Id_DonNhapHang" id="FK_Id_DonNhapHang">
              <div class="d-flex justify-content-between align-items-center gap-5 mb-3">
                <div class="form-group">
                  <label for="Id_LoaiHang" class="form-label">Loại hàng</label>
                  <select class="form-select" style="width: 200px;" name="Id_LoaiHang" id="Id_LoaiHang">
                    @foreach($categories as $each)
                    <option value="{{ $each->Id_LoaiHang }}">{{ $each->Ten_LoaiHang }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group" style="width: 50%">
                  <label for="FK_Id_MatHang" class="form-label">Mặt hàng</label>
                  <select class="form-select" name="FK_Id_MatHang" id="FK_Id_MatHang">
                  </select>
                </div>
                <div class="form-group">
                  <label for="count" class="form-label">Số lượng</label>
                  <input type="number" name="count" id="count" class="form-control">
                </div>
              </div>
              <button id="btn-add-data" class="btn btn-success">Thêm chi tiết đơn hàng</button>
            </form>
          </div>
          <div class="card-footer">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 150px;" scope="col">Loại hàng</th>
                  <th class="text-center" scope="col">Tên mặt hàng</th>
                  <th class="text-center" scope="col">Đơn vị tính</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Thành tiền</th>
                </tr>
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $("select[name='Id_LoaiHang']").change(function () {
      let Id_LoaiHang = $(this).val();
      let token = $("input[name='_token']").val();

      $.ajax({
        url: "{{ url('/showItemsInCategory') }}",
        method: 'POST',
        data: {
          Id_LoaiHang: Id_LoaiHang,
          _token: token
        },
        success: function (data) {
          $("select[name='FK_Id_MatHang']").html('');
          $.each(data, function (key, value) {
            $("select[name='FK_Id_MatHang']").append(
              "<option value=" + value.Id_MatHang + ">" + value.Ten_MatHang + "</option>"
            );
          });
        }
      });
    });
    $("#formAjax").on('submit', function (event) {
      event.preventDefault();
      $.ajax({
        url: "{{ route('donhang.store') }}",
        type: 'post',
        data: $('#formAjax').serialize(),
        dataType: "json",
        success: function (response) {
          let id = response.latestOrder;
          $("input[name='FK_Id_DonNhapHang']").val(id);
        },
      });
    });
    $("#myForm").on('submit', function (event) {
      event.preventDefault();
      $.ajax({
        url: "{{ url('/add-data') }}",
        type: 'post',
        data: $('#myForm').serialize(),
        dataType: "json",
        success: function (response) {
          let htmls = "";
          $.each(response.row, function (key, value) {
            htmls += '<tr>' +
              '<td class="text-center">' + value.Ten_LoaiHang + '</td>' +
              '<td class="text-center">' + value.Ten_MatHang + '</td>' +
              '<td class="text-center">' + value.DonViTinh + '</td>' +
              '<td class="text-center">' + value.DonGia + '</td>' +
              '<td class="text-center">' + value.count + '</td>' +
              '<td class="text-center">' + value.DonGia * value.count + '</td>' +
              '</tr>';
          });
          $("#table-data").html(htmls);
        },
      });
    });

    console.log($("input[name='Ngay_DatHang']"));
    $("input[name='Ngay_DatHang']").on('change', function () {
      console.log($(this));
      let selectedDate = new Date($(this).val());
      let currentDate = new Date();

      if (selectedDate > currentDate) {
        $(this).next().html('Không thể chọn ngày tương lai');
        $(this).addClass('is-invalid');
      }
      else {
        $(this).next().html('');
        $(this).removeClass('is-invalid');
      }
    });
  });
</script>
@endsection