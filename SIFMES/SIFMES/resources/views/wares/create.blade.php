@extends('layouts.master')

@section('title', 'Thêm kho chứa')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-color px-2 py-3 rounded">
          <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
          <li class="breadcrumb-item active">
            <a class="text-decoration-none" href="{{ route('wares.index') }}">Quản lý kho chứa</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Thêm kho chứa</li>
        </ol>
      </nav>
      <div class="card">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Cấu hình kho chứa</h4>
        </div>
        <div class="card-body">
          <form action="" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <label class="input-group-text" for="warehouse">Kho chứa</label>
                  <select class="form-select" name="FK_Id_Station" id="warehouse">
                    @foreach ($stations as $each)
                    <option value="{{ $each->Id_Station }}">{{ $each->Name_Station }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="input-group mb-3">
                  <span class="input-group-text">Nhập số hàng</span>
                  <input type="number" class="form-control" min="1" maxlength="3" id="colNumber" name="colNumber">
                </div>
              </div>
              <div class="col-md-2">
                <div class="input-group mb-3">
                  <span class="input-group-text">Nhập số cột</span>
                  <input type="number" class="form-control" min="1" id="rowNumber" maxlength="3" name="rowNumber">
                </div>
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary-color" id="showBtn">
                  Xem trước
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card my-3">
        <div class="card-header p-0 overflow-hidden">
          <h4 class="card-title m-0 bg-primary-color p-3">Chi tiết kho chứa</h4>
        </div>
        <div class="card-body px-5">
          <h4 class="card-subtitle text-uppercase text-center mb-3">Số hàng và cột của kho</h4>
          <table class="table table-bordered border-primary">
            <tr class="d-none">
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
              <td class="square-cell">1</td>
            </tr>
          </table>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary d-none" id="saveBtn" data-bs-toggle="modal" data-bs-target="#exampleModal"
              style="background-color: #2b4c72">Lưu</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận hành động</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Bạn chắc chắn muốn khởi tạo kho này?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirmBtn"
                      style="background-color: #2b4c72">Xác nhận</button>
                  </div>
                </div>
              </div>
            </div>
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
    var data = [];

    function preview() {
      data.length = 0;
      $('.table tr').empty();
      var col = $('#rowNumber').val();
      var row = $('#colNumber').val();;
      var count = 0;
      for (var i = 1; i <= row; i++) {
        var newRow = $('<tr></tr>');

        for (var j = 1; j <= col; j++) {
          count++;
          var newCol = $('<td class="position-relative"></td>');
          newCol.addClass("square-cell");
          newCol.attr("data-col", +j);
          newCol.attr("data-row", +i);
          newCol.attr("id", "cell" + count);
          newCol.attr("data-status", 1);
          var info = $('<p class="text-end position-absolute top-0 end-0"></p>');
          info.text(i + '.' + j);
          newCol.append(info);
          newCol.css("background-color", "#ffffff");
          newCol.append($('<p class="small">Trống</p>'));
          newRow.append(newCol);

          data.push([i, j, 1]);
        }
        $('.table').append(newRow);
      }
    }

    function showDetails() {
      var ware = $('#warehouse option:selected').val();
      $.ajax({
        url: 'showDetails',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          ware: ware,
        },
        success: function (response) {
          if (response.count == 0) {

          } else {
            $('#showBtn').prop('disabled', true);
            $('#saveBtn').addClass('d-none');
            var details = response.details;
            var col = response.col;
            var row = response.row;
            var count = 0;
            for (var i = 1; i <= row; i++) {
              var newRow = $('<tr></tr>');
              for (var j = 1; j <= col; j++) {
                count++;
                var newCol = $('<td class="position-relative"></td>');
                newCol.addClass("square-cell");
                newCol.attr("data-col", +j);
                newCol.attr("data-row", +i);
                newCol.attr("id", "cell" + count)
                var info = $(
                  '<p class="text-end position-absolute top-0 end-0"></p>');
                info.text(i + '.' + j);
                newCol.append(info);
                newRow.append(newCol);
              }

              $('.table').append(newRow);
            }
            for (var i = 1; i <= col * row; i++) {
              if (details[i - 1].FK_Id_StateCell == "1") {
                $('#cell' + i).css("background-color", "#ffffff");
                $('#cell' + i).attr("data-status", 1);
                $('#cell' + i).append($('<p class="small">Trống</p>'));
              } else if (details[i - 1].FK_Id_StateCell == "0") {
                $('#cell' + i).css("background-color", "#dbd6d6");
                $('#cell' + i).attr("data-status", 0)
                $('#cell' + i).append($('<p class="small">Không thể sử dụng</p>'));
              }
            }
          }
        }
      });
    }
    showDetails();
    $('#warehouse').change(function () {
      var ware = $(this).val();
      $('#colNumber').val("");
      $('#rowNumber').val("");
      $('.table tr').empty();

      $.ajax({
        url: 'showDetails',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          ware: ware,
        },
        success: function (response) {
          if (response.count == 0) {
            $('.table tr').empty();
            $('#showBtn').prop('disabled', false);
            $('#saveBtn').addClass('d-none');
          } else {
            $('#showBtn').prop('disabled', true);
            showDetails();
          }

        }
      });
    });
    $.contextMenu({
      selector: ".square-cell",
      build: function ($trigger) {
        var options = {
          callback: function (key, options) {
            var col = $(this).data('col');
            var row = $(this).data('row');
            var ware = $('#warehouse option:selected').val();
            var check = $('#showBtn').prop('disabled');
            if (check) {

              $.ajax({
                url: 'setCellStatus',
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
                },
                data: {
                  row: row,
                  col: col,
                  ware: ware,
                  status: key,
                },
                success: function (response) {
                  $('.table tr').empty();
                  showDetails();
                },
              });
            } else {
              var cellID = $('[data-col="' + col + '"][data-row="' + row + '"]').attr('id');
              var id = cellID.match(/\d+/)[0];
              console.log(data[id - 1]);
              if (key == 0) {
                $(this).attr('data-status', key);
                $(this).css("background-color", "#dbd6d6");
                $(this).find('.small').text("Không thể sử dụng");
                data[id - 1] = [row, col, Number(key)];
              } else {
                $(this).attr('data-status', key);
                $(this).css("background-color", "#ffffff");
                $(this).find('.small').text("Trống");
                data[id - 1] = [row, col, Number(key)];
              }
            }
          },
          items: {}
        };

        var status = $trigger.attr('data-status');
        if (status == 1) {
          options.items = {
            0: {
              name: "Không thể sử dụng",
            },
            1: {
              name: "Trống",
              disabled: true,
            },
          };
        } else {
          options.items = {
            0: {
              name: "Không thể sử dụng",
              disabled: true,
            },
            1: {
              name: "Trống",
            },
          };
        }

        return options;
      }

    });

    $('#showBtn').click(function (e) {
      e.preventDefault();
      var col = $('#rowNumber').val();
      var row = $('#colNumber').val();
      $('#saveBtn').prop('disabled', false);
      if (col !== "" && row !== "") {
        if (/^\d+$/.test(col) && /^\d+$/.test(row)) {
          if (parseInt(col, 10) > 0 && parseInt(row, 10) > 0) {
            preview();
            $('#saveBtn').removeClass('d-none');
          } else {
            $(".toast-body").addClass("bg-danger");
            $("#icon").addClass("fa-xmark-circle");
            $("#toast-msg").html("Số hàng và cột phải lớn hơn 0!");
            toastBootstrap.show();
          }
        } else {
          $(".toast-body").addClass("bg-danger");
          $("#icon").addClass("fa-xmark-circle");
          $("#toast-msg").html("Vui lòng nhập lại!");
          toastBootstrap.show();
        }

      } else {
        $(".toast-body").addClass("bg-warning");
        $("#icon").addClass("fa-xmark-circle");
        $("#toast-msg").html("Vui lòng điền đầy đủ số hàng và số cột!");
        toastBootstrap.show();
      }
    });

    $('#confirmBtn').click(function (e) {
      e.preventDefault();
      $('.table tr').empty();
      var rowNumber = $('#rowNumber').val();
      var colNumber = $('#colNumber').val();
      var ware = $('#warehouse option:selected').val();
      $.ajax({
        url: 'createWare',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          data: JSON.stringify(data),
          ware: ware,
          col: rowNumber,
          row: colNumber,
        },
        success: function (response) {
          if (response.flag) {
            $(".toast-body").addClass("bg-success");
            $("#icon").addClass("fa-check-circle");
            $("#toast-msg").html('Khởi tạo kho thành công');
            toastBootstrap.show();
            $('#rowNumber').val("");
            $('#colNumber').val("");
            $('.table tr').empty();
          } else {
            $(".toast-body").addClass("bg-warning");
            $("#icon").addClass("fa-xmark-circle");
            $("#toast-msg").html('Khởi tạo kho thất bại, kho đã tồn tại!');
            toastBootstrap.show();
            $('.table tr').empty();
          }
          showDetails();
        },
        error: function (error) {
          console.log(error.responseJSON.message);
        }
      });
    })
  });
</script>
@endpush