@extends('layouts.master')

@section('title', 'Điều phối đơn hàng')

@section('content')
<div>
  <div class="container-fluid border-primary-subtle">
    <nav aria-label="breadcrumb" class="row mx-2 my-4">
      <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Xử lý đơn hàng</li>
      </ol>
    </nav>
    <div class="card">
      <div class="card-header p-0 overflow-hidden">
        <h4 class="card-title m-0 bg-primary-color p-3">Xử lý đơn hàng</h4>
      </div>
      <div class="row my-3 px-3 py-1">
        <div class="col-2">
          <div class="input-group mb-3">
            <label class="input-group-text" for="status">Hiển thị</label>
            <select class="form-select" id="status">
              <option value="0">Sản xuất</option>
              <option value="1">Đóng gói</option>
              <option value="2">Giao hàng</option>
            </select>
          </div>
        </div>
      </div>
      <table class="table table-bordered table-hover">
        <thead class="text-center">
          <th scope="col"></th>
          <th scope="col">Mã đơn hàng</th>
          <th scope="col">Kiểu gói</th>
          <th scope="col">Trạng thái</th>
          <th scope="col">Mô tả</th>
          <th scope="col">Số lượng</th>
          <th scope="col">Ngày giao hàng</th>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="row px-3 py-1">
        <div class="col-5">
          <div class="input-group mb-3">
            <label class="input-group-text" for="prodStationLine">Dây chuyền sản xuất</label>
            <select class="form-select" id="prodStationLine">
              @foreach ($psl as $item)
              <option value="{{ $item->Id_ProdStationLine }}">{{ $item->Name_ProdStationLine }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-6">
          <div class="input-group mb-3">
            <label class="input-group-text" for="type">Loại</label>
            <input type="text" class="form-control" id="type" readonly>
          </div>
        </div>
        <div class="col-1">
          <button class="btn btn-primary-color" data-bs-toggle="modal" data-bs-target="#modalstart"
            id="dispatchBtn">Khởi
            động</button>
          <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Bạn chắc chắn muốn khởi động quá trình xử lí đơn hàng này?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  <button type="button" class="btn btn-primary btn-primary-color" data-bs-dismiss="modal"
                    id="confirmBtn">Xác nhận</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tổng quan</span>
            <input type="text" class="form-control" id="overview" readonly>
          </div>
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

    $('.modal').attr('id', 'abc');

    $('#prodStationLine').change(function () {
      var selectedValue = $(this).val();
      $.ajax({
        url: '/dispatchs/getProductStation',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          value: selectedValue,
        },
        success: function (response) {
          $('#overview').val(response[0].Description);
          $('#type').val(response[0].Name_OrderType);
        }
      });
    });

    let secondOptionValue = $('#prodStationLine').val();
    $('#prodStationLine').val(secondOptionValue);
    $('#prodStationLine').change();

    $('#status').change(function () {
      id = [];
      count = 0;
      $('.modal').attr('id', 'abc');
      var selectedValue = $(this).val();
      $.ajax({
        url: '/dispatchs/getStatus',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          value: selectedValue,
        },
        success: function (response) {
          var list = response;
          $('.table tbody').empty();

          for (let i = 0; i < list.length; i++) {
            var element = list[i];
            $newRow = $('<tr class="text-center"></tr>');
            var col1 = $(
              '<td> <input class="form-check-input me-1 checkbox" type="checkbox"></td>'
            );
            col1.find('input').attr('value', element['Id_OrderLocal']);
            col1.find('input').attr('id', 'cb' + element['Id_OrderLocal']);
            var col2 = $('<td></td>')
            col2.text(element['Id_OrderLocal'])
            var col3 = $('<td></td>');
            if (element['SimpleOrPack'] == 0) {
              col3.text("Thùng hàng");
            }
            else if (element['SimpleOrPack'] == 1) {
              col3.text("Gói hàng");
            }
            var col4 = $('<td></td>');
            if (element['MakeOrPackOrExpedition'] == 0) {
              col4.text("Sản xuất");
            } else if (element['MakeOrPackOrExpedition'] == 1) {
              col4.text("Đóng gói");
            } else if (element['MakeOrPackOrExpedition'] == 2) {
              col4.text("Giao hàng");
            }
            var col5 = $('<td></td>');
            var a = $(
              `<a class="btn btn-sm btn-outline-light text-primary-color border-secondary" target="_blank">
                  <i class="fa-solid fa-eye"></i>
              </a>`
            );
            a.attr('href', 'http://127.0.0.1:8000/orderLocals/makes/' + element[
              'Id_OrderLocal']);
            col5.append(a);

            var col6 = $('<td></td>');
            col6.text(element['Count']);

            var col7 = $('<td></td>');
            var dateTimeString = element['DateDilivery'];
            var dateTime = new Date(dateTimeString);
            var year = dateTime.getFullYear();
            var month = ("0" + (dateTime.getMonth() + 1)).slice(-2);
            var day = ("0" + dateTime.getDate()).slice(-2);

            // Format the date string in the desired format
            var formattedDate = day + "-" + month + "-" + year;
            col7.text(formattedDate);
            $newRow.append(col1, col2, col3, col4, col5, col6, col7);
            $('.table tbody').append($newRow);
          }
        }
      });
    });

    let firstOptionValue = $('#status').val();
    $('#status').val(firstOptionValue);
    $('#status').change();

    var id = [];
    $(document).on("change", ".checkbox", function () {
      let checkedValue = $(this).attr('id').match(/\d+/)[0];
      if ($(this).is(':checked')) {
        id.push(checkedValue);
      } else {
        id = id.filter(function (element) {
          return element !== checkedValue;
        });
      }

      if (id.length >= 1) {
        $('.modal').attr('id', 'modalstart');
      }
      else {
        $('.modal').attr('id', 'abc');
      }
    })

    $('#dispatchBtn').on('click', function () {
      if (id.length < 1) {
        $(".toast-body").addClass("bg-warning");
        $("#icon").addClass("fa-xmark-circle");
        $("#toast-msg").html("Bạn chưa chọn hoá đơn nào!");
        toastBootstrap.show();
      }
      else if (id.length >= 1) {
        $('#confirmBtn').on('click', function () {
          var prodStationLine = $('#prodStationLine option:selected').val();
          $.ajax({
            url: '/dispatchs/store',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              id: id,
              stationProd: prodStationLine,
            },
            success: function (response) {
              $(".toast-body").addClass("bg-success");
              $("#icon").addClass("fa-check-circle");
              $("#toast-msg").html("Khởi động đơn hàng thành công!");
              toastBootstrap.show();
              setTimeout(() => {
                window.location.reload();
              }, 500);
            }
          });
        })
      }
    });

  });
</script>
@endpush