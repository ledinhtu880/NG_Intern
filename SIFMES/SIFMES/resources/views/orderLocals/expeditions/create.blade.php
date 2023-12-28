@extends('layouts.master')

@section('title', 'Tạo đơn giao hàng')

@push('css')
<style>
  .hiddenRow {
    padding: 0 !important;
  }
</style>
@endpush

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Danh sách đơn hàng</h4>
          </div>
          <div class="card-body px-0">
            <div class="px-3 mb-3 d-flex justify-content-between align-items-center">
              <div class="input-group" style="width: 200px;">
                <label class="input-group-text bg-secondary-subtle" for="Kho">Kho</label>
                <select name="kho" id="kho" class="form-select">
                  <option value="406">406</option>
                  <option value="409">409</option>
                </select>
              </div>
            </div>
            <table class="table text-center table-expedition table-striped m-0">
              <thead id="table-heading">
                <th scope="col">Chọn</th>
                <th scope="col">Mã đơn hàng</th>
                <th scope="col">Khách hàng</th>
                <th scope="col">Kiểu hàng</th>
                <th scope="col">Số lượng thùng chứa</th>
                <th scope="col">Đơn giá thùng chứa</th>
              </thead>
              <tbody id="table-data">
              </tbody>
            </table>
          </div>

          <div class="card-footer">
            <div class="d-flex align-content-center justify-content-between">
              <button type="submit" class="btn btn-primary-color px-3" id="them">
                <i class="fa-solid fa-plus text-white me-2"></i>Thêm
              </button>
              <div class="input-group" style="width: 300px;">
                <label class="input-group-text bg-secondary-subtle" for="Date_Delivery">
                  Ngày giao hàng
                </label>
                <input type="date" name="Date_Delivery" id="Date_Delivery" class="form-control"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Đơn giao hàng</h4>
          </div>
          <div class="card-body px-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Mã đơn hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Kiểu hàng</th>
                  <th class="text-center" scope="col">Trạng thái</th>
                  <th class="text-center" scope="col">Ngày giao hàng</th>
                  <th class="text-center" scope="col">Mô tả</th>
                </tr>
              </thead>
              <tbody id="table-result">
                @foreach ($data as $item)
                <tr class="text-center">
                  <td><input type="checkbox" class="input-check checkbox2" value="{{ $item->Id_OrderLocal }}"
                      data-id="cb{{ $item->Id_OrderLocal }}"></td>
                  <td>{{ $item->Id_OrderLocal }}</td>
                  <td>{{ $item->Count }}</td>
                  <td>{{ $item->type }}</td>
                  <td>{{ $item->status }}</td>
                  <td>{{ $item->deliveryDate }}</td>
                  <td><button type="button" class="btnShow btn btn-sm btn-outline-light
                                                text-primary-color border-secondary" data-bs-toggle="modal"
                      data-bs-target="#show-{{ $item->Id_OrderLocal }}" data-id="{{ $item->Id_OrderLocal }}">
                      <i class="fa-solid fa-eye"></i>
                    </button>

                    <div class="modal fade" id="show-{{ $item->Id_OrderLocal }}" tabindex="-1"
                      aria-labelledby="show-{{ $item->Id_OrderLocal }}Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                            <h5 class="modal-title w-100 " id="exampleModalLabel">
                              Thông tin chi tiết đơn hàng số
                              {{ $item->Id_OrderLocal }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-details table-striped m-0">
                              <thead>
                                <tr>
                                  <th class="text-center" scope="col">Nguyên
                                    liệu</th>
                                  <th class="text-center" scope="col">Số
                                    lượng
                                    nguyên liệu</th>
                                  <th class="text-center" scope="col">Đơn vị
                                  </th>
                                  <th class="text-center" scope="col">Thùng
                                    chứa</th>
                                  <th class="text-center" scope="col">Số
                                    lượng
                                    thùng chứa</th>
                                  <th class="text-center" scope="col">Đơn giá
                                  </th>
                                </tr>
                              </thead>
                              <tbody class="table-simples" class="p-5" data-value="{{ $item->Id_OrderLocal }}">
                              </tbody>
                            </table>
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
            <button class="btn btn-primary-color px-3" id="xoa">
              <i class="fa-solid fa-minus text-white me-2"></i>Xóa
            </button>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end my-3">
          <a href="{{ route('orderLocals.expeditions.index') }}" class="btn btn-warning px-4">Quay lại</a>
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
<script>
  $(document).ready(function () {
    const toastLiveExample = $("#liveToast");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    $('#kho').change(function () {
      var selectedValue = $(this).val();
      count1 = 0;
      count2 = 0;
      $.ajax({
        url: '/orderLocals/expeditions/getOrder',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          value: selectedValue,
        },
        success: function (response) {
          var list = response;
          $('.table-expedition tbody').empty();
          for (let i = 0; i < list.length; i++) {
            var element = list[i];
            if (selectedValue == 406) {
              let type_container = '';
              if (element['FK_Id_ContainerType'] == 0) {
                type_container = "Hộp vuông";
              } else if (element['FK_Id_ContainerType'] == 1) {
                type_container = "Hộp tròn";
              }

              let html = `<tr class="text-center">
                                                <td class="d-flex justify-content-center">
                                                    <input class="form-check me-1 checkbox1" type="checkbox" value="${element['Id_ContentSimple']}" id="cb${element['Id_ContentSimple']}" data-id="${element['Id_ContentPack']}">
                                                </td>
                                                <td>${element['Id_Order']}</td>
                                                <td>${element['Name_Customer']}</td>
                                                <td>
                                                    ${type_container}
                                                </td>
                                                <td>${element['Count_Container']}</td>
                                                <td>${Number(element['Price_Container']).toLocaleString()} VNĐ</td>
                                            </tr>`;
              $('.table-expedition tbody').append(html);
            } else if (selectedValue == 409) {
              let simpleOrPack = '';
              if (element['SimpleOrPack'] == 0) {
                simpleOrPack = "Thùng hàng";
              } else if (element['SimpleOrPack'] == 1) {
                simpleOrPack = "Gói hàng";
              }
              let html = `<tr class="text-center">
                                                <td class="d-flex justify-content-center">
                                                    <input class="form-check me-1 checkbox1" type="checkbox" value="${element['Id_ContentPack']}" id="cb${element['Id_ContentPack']}" data-id="${element['Id_ContentPack']}">
                                                </td>
                                                <td>${element['Id_Order']}</td>
                                                <td>${element['Name_Customer']}</td>
                                                <td>
                                                    ${simpleOrPack}
                                                </td>
                                                <td>${element['Count_Pack']}</td>
                                                <td>${Number(element['Price_Pack']).toLocaleString()} VNĐ</td>
                                            </tr>`;
              $('.table-expedition tbody').append(html);
            }
          }
        }
      });
    });

    $('#kho').change();

    var id1 = [];
    var id2 = [];
    var count1 = 0;
    var count2 = 0;
    $(document).on("change", ".checkbox1", function () {
      let checkedValue = $(this).attr('id').match(/\d+/)[0];
      if ($(this).is(':checked')) {
        id1.push(checkedValue);
        count1++;

      } else {
        count1--;
        id1 = id1.filter(function (element) {
          return element !== checkedValue;
        });
      }
    })

    $(document).on("change", ".checkbox2", function () {
      let checkedValue = $(this).attr('data-id').match(/\d+/)[0];
      if ($(this).is(':checked')) {
        id2.push(checkedValue);
        count2++;
      } else {
        count2--;
        id2 = id2.filter(function (element) {
          return element !== checkedValue;
        });
      }
    })

    $('.btnShow').on('click', function () {
      let id = $(this).attr('data-id').match(/\d+/)[0];
      $('.table-details tbody tr').empty();
      $.ajax({
        url: '/orderLocals/expeditions/showDetails',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
        },
        success: function (response) {
          var details = response;
          for (let index = 0; index < details.length; index++) {
            let element = details[index];
            let type_container = '';
            if (element['FK_Id_ContainerType'] == 0) {
              type_container = "Hộp vuông";
            } else if (element['FK_Id_ContainerType'] == 1) {
              type_container = "Hộp tròn";
            }

            let html = `<tr class="text-center">
                            <td>${element['Name_RawMaterial']}</td>
                            <td>${Number(element['Count_RawMaterial']).toLocaleString()}</td>
                            <td>${element['Unit']}</td>
                            <td>
                                ${type_container}
                            </td>
                            <td>${element['Count_Container']}</td>
                            <td>${Number(element['Price_Container'])} VNĐ</td>
                        </tr>`;

            $('.table-details').append(html);
          }
        },
        error: function (error) {
          console.log(error.responseText);
        }
      });
    });

    $('#them').on('click', function () {
      if (count1 < 1) {
        $(".toast-body").addClass("bg-warning");
        $("#icon").addClass("fa-xmark-circle");
        $("#toast-msg").html("Bạn chưa chọn hoá đơn nào để tạo đơn giao!");
        toastBootstrap.show();
      } else {
        var kho = $('#kho option:selected').val();
        var date = $('#Date_Delivery').val();
        $.ajax({
          url: '/orderLocals/expeditions/store',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            id: id1,
            station: kho,
            date: date,
          },
          success: function (response) {
            $(".toast-body").addClass("bg-success");
            $("#icon").addClass("fa-check-circle");
            $("#toast-msg").html("Tạo đơn giao hàng thành công");
            toastBootstrap.show();
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          }
        });
      }
    });

    $('#xoa').on('click', function () {
      if (count2 < 1) {
        $(".toast-body").addClass("bg-warning");
        $("#icon").addClass("fa-xmark-circle");
        $("#toast-msg").html("Bạn chưa chọn hoá đơn nào để xoá!");
        toastBootstrap.show();
      } else {
        $.ajax({
          url: '/orderLocals/expeditions/delete',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            id: id2,
          },
          success: function (response) {
            $(".toast-body").addClass("bg-success");
            $("#icon").addClass("fa-check-circle");
            $("#toast-msg").html("Xoá đơn giao hàng thành công");
            toastBootstrap.show();
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          }
        });
      }
    });
  });
</script>
@endpush