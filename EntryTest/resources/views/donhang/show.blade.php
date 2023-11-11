@extends('layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="mt-3">
        <div class="card">
          <input type="hidden" id="Id_DonHang" name="id" value="{{ $donhang->id }}">
          <div class="card-header">
            <h4 class="card-title text-center">Chi tiết đơn hàng</h4>
            <div class="d-flex flex-column px-5">
              <div class="d-flex align-items-center justify-content-start gap-5">
                <span class="w-25">
                  <strong>Mã đơn hàng:</strong> {{ $donhang->id }}
                </span>
                <span class="w-25">
                  <strong>Tên nhà cung cấp:</strong> {{ $donhang->getSupplierAttribute('Ten_NCC', $donhang->id) }}
                </span>
                <span class="w-25" class="align-self-center">
                  <strong>Ngày đặt hàng:</strong> {{ $donhang->Ngay_DatHang }}</span>
              </div>
              <div class="d-flex align-items-center justify-content-start gap-5">
                <span class="w-25">
                  <strong>Địa chỉ:</strong> {{ $donhang->getSupplierAttribute('Dia_Chi', $donhang->id) }}
                </span>
                <span class="w-25" class="align-self-center">
                  <strong>Trạng thái:</strong> {{ $donhang->TrangThai }}</span>
              </div>
            </div>
          </div>
          <div class="card-body px-0">
            <table class="table table-bordered table-striped w-100">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Loại hàng</th>
                  <th class="text-center" scope="col">Tên mặt hàng</th>
                  <th class="text-center" scope="col">Đơn vị tính</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $each)
                <tr class="js-row">
                  <td class="text-center">
                    {{ $each->Ten_LoaiHang }}
                  </td>
                  <td class="text-center">
                    {{ $each->Ten_MatHang }}
                  </td>
                  <td class="text-center">
                    {{ $each->DonViTinh }}
                  </td>
                  <td class="text-center">
                    {{ $each->DonGia }}
                  </td>
                  <td class="text-center">
                    {{ $each->count }}
                  </td>
                  <td class="text-center">
                    @php $total += ((int)$each->count * (int)$each->DonGia) @endphp
                    {{ (int)$each->count * (int)$each->DonGia}}
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5" class="text-end fw-bold pe-4">Tổng tiền</td>
                  <td class="text-center">
                    {{ $total }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <a href="{{ route('index') }}" class="float-end btn btn-warning">Quay lại</a>
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
    let url = "{{ url('/showItemsInCategory') }}";
    $("select[name='Id_LoaiHang']").change(function () {
      let rowElement = $(this).closest('.js-row');
      let Id_LoaiHang = $(this).val();
      var token = rowElement.find("input[name='_token']").val();

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          Id_LoaiHang: Id_LoaiHang,
          _token: token
        },
        success: function (data) {
          rowElement.find("select[name='Id_MatHang']").html('');
          $.each(data, function (key, value) {
            rowElement.find("select[name='Id_MatHang']").append(
              "<option value=" + value.Id_MatHang + ">" + value.Ten_MatHang + "</option>"
            );
            rowElement.find("input[name='DonViTinh']").val(value.DonViTinh);
            rowElement.find("input[name='DonGia']").val(value.DonGia);
          });
        }
      });
      $("select[name='Id_MatHang']").change(function () {
        let Id_MatHang = $(this).val();
        let token = rowElement.find("input[name='_token']").val();
        let url = "{{ url('/getDetailItem') }}";

        $.ajax({
          url: url,
          method: 'POST',
          data: {
            Id_MatHang: Id_MatHang,
            _token: token
          },
          success: function (data) {
            $.each(data, function (key, value) {
              rowElement.find("input[name='DonViTinh']").val(value.DonViTinh);
              rowElement.find("input[name='DonGia']").val(value.DonGia);
              rowElement.find("input[name='TongTien']").val(rowElement.find("input[name='SoLuong']").val() * value.DonGia);
            });
          }
        });
      })
      rowElement.find("input[name='SoLuong']").change(function () {
        let tongTien = rowElement.find("input[name='DonGia']").val() * $(this).val();
        rowElement.find("input[name='TongTien']").val(tongTien);
      })
    });
  });
</script>
@endsection