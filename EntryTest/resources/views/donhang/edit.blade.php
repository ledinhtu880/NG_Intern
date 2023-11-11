@extends('layouts.master')

@section('title', 'Sửa đơn hàng')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-100 mt-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title m-0">Sửa đơn hàng</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('donhang.update', $donhang->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="d-flex justify-content-between gap-5">
                <div class="form-group flex-grow-1">
                  <label class="form-label">Nhà cung cấp</label>
                  @if($errors->has('FK_Id_NCC'))
                  <select name="FK_Id_NCC" id="FK_Id_NCC" class="form-select is-invalid">
                    @foreach($ncc as $each)
                    @if($each->Id_NCC !== $donhang->FK_Id_NCC)
                    <option value="{{ $each->Id_NCC }}">
                      {{ $each->Ten_NCC }}
                    </option>
                    @else
                    <option value="{{ $each->Id_NCC }}" selected>
                      {{ $each->Ten_NCC }}
                    </option>
                    @endif
                    @endforeach
                  </select>
                  <span class="text-danger">
                    {{ $errors->first('FK_Id_NCC') }}
                  </span>
                  @else
                  <select name="FK_Id_NCC" id="FK_Id_NCC" class="form-select">
                    @foreach($ncc as $each)
                    @if($each->Id_NCC === $donhang->FK_Id_NCC)
                    <option value="{{ $each->Id_NCC }}" selected>
                      {{ $each->Ten_NCC }}
                    </option>
                    @else
                    <option value="{{ $each->Id_NCC }}">
                      {{ $each->Ten_NCC }}
                    </option>
                    @endif
                    @endforeach
                  </select>
                  @endif
                </div>
                <div class="form-group flex-grow-1">
                  <label class="form-label">Trạng thái</label>
                  @if($errors->has('TrangThai'))
                  <select name="TrangThai" class="form-select is-invalid">
                    @foreach($enumTypes as $each)
                    @if($each === $donhang->TrangThai)
                    <option value="{{ $each }}" selected> {{ $each }} </option>
                    @else
                    <option value="{{ $each }}"> {{ $each }} </option>
                    @endif
                    @endforeach
                  </select>
                  <span class="text-danger">
                    {{ $errors->first('TrangThai') }}
                  </span>
                  @else
                  <select name="TrangThai" class="form-select">
                    @foreach($enumTypes as $each)
                    @if($each === $donhang->TrangThai)
                    <option value="{{ $each }}" selected> {{ $each }} </option>
                    @else
                    <option value="{{ $each }}"> {{ $each }} </option>
                    @endif
                    @endforeach
                  </select>
                  @endif
                </div>
                <div class="form-group flex-grow-1">
                  <label for="Ngay_DatHang" class="form-label">Ngày đặt hàng</label>
                  @if($errors->has('Ngay_DatHang'))
                  <input type="date" name="Ngay_DatHang" id="Ngay_DatHang" class="form-control is-invalid"
                    placeholder="Nhập ngày đặt hàng" value="{{ old('Ngay_DatHang') }}">
                  <span class="text-danger">
                    {{ $errors->first('Ngay_DatHang') }}
                  </span>
                  @else
                  <input type="date" name="Ngay_DatHang" id="Ngay_DatHang" class="form-control"
                    placeholder="Nhập ngày đặt hàng" value="{{ $donhang->Ngay_DatHang }}">
                  @endif
                </div>
              </div>
              <div class="d-flex justify-content-end my-4 gap-3">
                <a href="{{ route('index') }}" class="btn btn-warning">Quay lại</a>
                <button type="submit" class="btn btn-success">Sửa đơn hàng</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card my-3">
          <div class="card-header">
            <h3 class="card-title m-0">Sửa chi tiết đơn hàng
            </h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Loại hàng</th>
                  <th class="text-center" scope="col">Tên mặt hàng</th>
                  <th class="text-center" scope="col">Đơn vị tính</th>
                  <th class="text-center" scope="col">Đơn giá</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Thành tiền</th>
                  <th class="text-center" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $each)
                <tr class="js-row">
                  <form class="formDetails" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $each->id }}">
                    <td data-id="category" class="text-center" style="width: 125px">{{ $each->Ten_LoaiHang}}</td>
                    <td style="width: 400px">
                      <select name="FK_Id_MatHang" class="form-select">
                        @foreach($items as $item)
                        @if($item->Id_MatHang === $each->FK_Id_MatHang)
                        <option value="{{ $item->Id_MatHang }}" selected>{{ $item->Ten_MatHang }}</option>
                        @else
                        <option value="{{ $item->Id_MatHang }}">{{ $item->Ten_MatHang }}</option>
                        @endif
                        @endforeach
                      </select>
                    </td>
                    <td class="text-center" data-id="unit">
                      {{ $each->DonViTinh }}
                    </td>
                    <td class="text-center" data-id="price">
                      {{ $each->DonGia }}
                    </td>
                    <td class="text-center">
                      <input class="form-control" type="number" name="count" id="count" value="{{ $each->count }}">
                    </td>
                    <td class="text-center" data-id="total">
                      {{ (int)$each->count * (int)$each->DonGia}}
                    </td>
                  </form>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                      data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $each->id }}">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="modal fade" id="deleteModal-{{ $each->id }}" tabindex="-1"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Bạn có chắc chắn về việc xóa đơn hàng này?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form class="formDelete">
                              <button type="submit" class="deleteBtn btn btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-end my-4 gap-3">
              <a href="{{ route('index') }}" class="btn btn-warning">Quay lại</a>
              <input type="hidden" name="id" value="{{ $donhang->id }}">
              <button class="btn btn-success" id="updateBtn">Sửa chi tiết đơn hàng</button>
            </div>
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
    $("select[name='FK_Id_MatHang']").on('change', function () {
      let FK_Id_MatHang = $(this).val();
      let token = $("input[name='_token']").val();
      let rowElement = $(this).closest(".js-row");

      $.ajax({
        url: "{{ url('/showDetailsItem') }}",
        method: 'POST',
        dataType: 'json',
        data: {
          FK_Id_MatHang: FK_Id_MatHang,
          _token: token
        },
        success: function (data) {
          let countInput = rowElement.find("input[name='count']");
          let countValue = countInput.val();

          let totalPrice = parseInt(data.DonGia) * parseInt(countValue);

          rowElement.find("[data-id='category']").html(data.Ten_LoaiHang);
          rowElement.find("[data-id='unit']").html(data.DonViTinh);
          rowElement.find("[data-id='price']").html(data.DonGia);
          rowElement.find("[data-id='total']").html(totalPrice);
        }
      });
    });
    $("input[name='count']").on('input', function () {
      let rowElement = $(this).closest(".js-row");
      let price = parseInt(rowElement.find("[data-id='price']").text());
      let countValue = parseInt($(this).val());
      rowElement.find("[data-id='total']").html(price * countValue);
    });
    $(".formDelete").on('submit', function (event) {
      event.preventDefault();

      $(this).each(function () {
        let rowElement = $(this).closest(".js-row");
        let id = rowElement.find("input[name='id']").val();
        console.log(id);
      });
    });
    $("#updateBtn").on('click', function () {
      let id = $("input[name='id']").val();
      let formDataArray = []
      let token = $("input[name='_token']").val();

      $(".formDetails").each(function () {
        let form = $(this)
        let formData = $(this).serialize();

        formDataArray.push(formData);
      })

      $.ajax({
        url: "{{ url('/update-data') }}",
        type: 'post',
        data: {
          formData: formDataArray,
          id: id,
          _token: token,
        },
        success: function (response) {
          window.location.href = '/';
        },
      });
    })
  });
</script>
@endsection