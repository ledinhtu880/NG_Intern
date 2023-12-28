@extends('layouts.master')

@section('title', 'Thêm dây chuyền')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
@endpush
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-50">
        <div class="card">
          <div class="card-header p-0 overflow-hidden">
            <h3 class="card-title m-0 bg-primary-color p-3 text-white">Thêm dây chuyền</h3>
          </div>
          <div class="card-body">
            <form method="POST">
              @csrf
              <div class="form-group">
                <label for="Name_ProdStationLine" class="form-label">Tên dây chuyền</label>
                <input type="text" name="Name_ProdStationLine" id="Name_ProdStationLine"
                  placeholder="Nhập tên dây chuyền"
                  class="form-control{{ $errors->has('Name_ProdStationLine') ? ' is-invalid' : '' }}"
                  value="{{ old('Name_ProdStationLine') }}">
                <span class="text-danger" id="err_nameProdStationLine" style="display:none;">
                  Vui lòng nhập tên dây chuyền
                </span>
              </div>
              <div class="form-group">
                <label for="Description" class="form-label">Mô tả</label>
                <textarea name="Description" id="Description" placeholder="Nhập mô tả"
                  class="form-control{{ $errors->has('Description') ? ' is-invalid' : '' }}">{{ old('Description') }}</textarea>
                <span class="text-danger">
                  {{ $errors->first('Description') }}
                </span>
              </div>
              <div class="form-group">
                <label for="FK_Id_OrderType" class="form-label">Chọn kiểu đơn hàng</label>
                <select name="FK_Id_OrderType" id="FK_Id_OrderType" class="form-control ">
                  @foreach ($orderTypes as $orderType)
                  <option value="{{ $orderType->Id_OrderType }}">
                    {{ $orderType->Name_OrderType }}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="Station_Start" class="form-label">Chọn trạm bắt đầu</label>
                  <select name="Station_Start" id="Station_Start" class="form-control">
                    <option value="401">SIF-401</option>
                    <option value="406">SIF-406</option>
                    <option value="409">SIF-409</option>
                  </select>
                  <span class="text-danger">
                    {{ $errors->first('Station_Start') }}
                  </span>
                </div>
                <div class="form-group col-md-6">
                  <label for="Station_End" class="form-label">Chọn trạm kết thúc</label>
                  <select name="Station_End" id="Station_End" class="form-control">
                    <option value="406">SIF-406</option>
                    <option value="407">SIF-407</option>
                    <option value="409">SIF-409</option>
                    <option value="412">SIF-412</option>
                  </select>
                </div>
              </div>
              <div id="Station_Mid" class="row">
                {{-- 401 --}}
                <div class="col-md" id="Mid">
                  <div class="row">
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 2</label>
                      <select name="" class="form-control station-select">
                        <option value="402">SIF-402</option>
                        <option value="403">SIF-403</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 3</label>
                      <select name="" class="form-control station-select" disabled>
                        <option value="405">SIF-405</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 4</label>
                      <select name="" class="form-control station-select">
                        <option value="406">SIF-406</option>
                        <option value="407">SIF-407</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 5</label>
                      <select name="" class="form-control station-select">
                        <option value="407">SIF-407</option>
                        <option value="408">SIF-408</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 6</label>
                      <select name="" class="form-control station-select">
                        <option value="408">SIF-408</option>
                        <option value="409">SIF-409</option>
                        <option value="410">SIF-410</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 7</label>
                      <select name="" class="form-control station-select">
                        <option value="409">SIF-409</option>
                        <option value="410">SIF-410</option>
                        <option value="411">SIF-411</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 8</label>
                      <select name="" class="form-control station-select">
                        <option value="410">SIF-410</option>
                        <option value="411">SIF-411</option>
                        <option value="412">SIF-412</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 9</label>
                      <select name="" class="form-control station-select" disabled>
                        <option value="411">SIF-411</option>
                        <option value="412">SIF-412</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group station-group">
                      <label for="" class="form-label station-label">Chọn trạm thứ 10</label>
                      <select name="" class="form-control station-select" disabled>
                        <option value="412">SIF-412</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end pb-5 my-4 gap-3">
                <a href="{{ route('index') }}" class="btn btn-warning">Quay lại</a>
                <button type="button" class="btn btn-primary-color" id="btn_add">Tạo</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('javascript')
<script src="{{ asset('js/app1.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {


    $("#FK_Id_OrderType").val(0);
    $("#FK_Id_OrderType").change();


    const btn_add = $("#btn_add");
    $("#Name_ProdStationLine").on('keyup', function () {
      if ($(this).val() == "") {
        $("#err_nameProdStationLine").show();
      } else {
        $("#err_nameProdStatonLine").hide();
      }
    });

    btn_add.on('click', function () {
      if ($("#Name_ProdStationLine").val() == "") {
        $("#err_nameProdStationLine").show();
      } else {
        let stationSelect = $(".station-select");
        var name = $("#Name_ProdStationLine").val();
        var stationStart = $("#Station_Start").val();
        var stationEnd = $("#Station_End").val();
        var stationLine = [$("#Station_Start").val()];
        var orderType = $('#FK_Id_OrderType').val();

        if (stationStart == 406 && stationEnd == 407) {
          stationLine.push('407');
        } else {
          stationSelect.each(function () {
            if (!$(this).is(':hidden')) {
              stationLine.push($(this).val());
            }
          });
        }

        $.ajax({
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            name: name,
            description: $("#Description").val(),
            stationLine: stationLine,
            orderType: orderType
          },
          dataType: 'json',
          url: '/productStationLines/create',
          success: function (data) {
            window.location.href = data.url;
          }
        });
      }
    });
  });
</script>
@endpush