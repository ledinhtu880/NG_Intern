$(document).ready(function () {
  var station_group = $(".station-group");
  var station_select = $(".station-select");
  var station_label = $(".station-label");
  var station_start = $("#Station_Start");
  var station_end = $("#Station_End");

  $("#FK_Id_OrderType").on("change", function () {
    $fk_id_orderType = $(this).val();
    disabledStation(station_start);
    disabledStation(station_end);

    if ($fk_id_orderType == 0) {
      station_start.val(401);
      station_start.change();
    } else if ($fk_id_orderType == 1) {
      station_start.val(406);
      station_start.change();
    } else if ($fk_id_orderType == 2) {
      station_end.val(409);
      station_start.val(406);
      station_end.change();
    } else if ($fk_id_orderType == 3) {
      station_start.val(409);
      station_start.change();
    }
  });

  // Khi thay đổi trạm đầu
  station_start.on("change", function () {
    hideAllStation(station_group);
    if ($(this).val() == 401) {
      // trạm bắt đầu bằng 401
      // Hiển thị lại lựa chọn 406, 407, 409 của select trạm cuối
      showStation($("#Station_End > option[value='406']"));
      // showStation($("#Station_End > option[value='407']"));
      // showStation($("#Station_End > option[value='409']"));
      hideStation($("#Station_End > option[value='407']"));
      hideStation($("#Station_End > option[value='409']"));
      hideStation($("#Station_End > option[value='412']"));
      // Đặt lại trạm cuối = 406
      station_end.val(406);

      station_end.change();
    } else if ($(this).val() == 406) {
      // trạm đầu bằng 406
      // Ẩn lựa chọn 406 của select trạm cuối
      hideStation($("#Station_End > option[value='406']"));
      // Đặt lại trạm cuối bằng 407
      station_end.val(407);

      station_end.change();
      // Hiển thị lại lựa chọn 407, 409 cho trạm cuối
      showStation($("#Station_End > option[value='407']"));
      showStation($("#Station_End > option[value='409']"));
    } else {
      // trạm đầu bằng 409
      // Ẩn lựa chọn 406, 407, 409
      hideStation($("#Station_End > option[value='406']"));
      hideStation($("#Station_End > option[value='407']"));
      hideStation($("#Station_End > option[value='409']"));
      // Đặt lại trạm cuối bằng 412
      station_end.val(412);
      station_end.change();
    }
  });

  // Khi thay đổi trạm cuối
  station_end.on("change", function () {
    // Ẩn tất cả các station
    let count = 2;
    hideAllStation(station_group);
    if (station_start.val() == 401) {
      if ($(this).val() == 406) {
        // trạm đầu là 401, trạm cuối là 406
        for (let i = 0; i < 3; i++) {
          showStation(station_group.eq(i));
        }
        disabledStation(station_select.eq(2));
      }
    } else if (station_start.val() == 406) {
      hideStation($("#Station_End > option[value='406']"));
      if (station_end.val() == 407) {
        hideAllStation(station_group);
      } else {
        if (station_end.val() == 409) {
          // trạm cuối = 409
          for (let i = 3; i < 6; i++) {
            showStation(station_group.eq(i));
            station_label.eq(i).html("Chọn trạm thứ " + count++);
          }
          unDisabledStation(station_select.eq(2));
          unDisabledStation(station_select.eq(2));
          disabledStation(station_select.eq(4));
          disabledStation(station_select.eq(5));
        } else {
          // trạm cuối = 412
          for (let i = 3; i < 9; i++) {
            showStation(station_group.eq(i));
            station_label.eq(i).html("Chọn trạm thứ " + count++);
          }
          station_select.eq(3).change();
        }
      }
    } else if (station_start.val() == 409) {
      if ($(this).val() == 412) {
        // Trạm dầu là 409, trạm cuối là 412
        for (let i = 6; i < 9; i++) {
          showStation(station_group.eq(i)); // Hiển thị station
          station_label.eq(i).html("Chọn trạm thứ " + count++); // Đổi tên station
        }
        disabledStation(station_select.eq(6)); // không cho lựa chọn eq6
      }
    }
  });

  station_select.eq(2).on("change", function () {
    // Sự kiện thay đổi trạm thứ 4
    // trạm 4 có 4 option là 406 và 407
    if (station_end.val() == 407 && $(this).val() == station_end.val()) {
      // Trạm 4 = 407 = trạm cuối
      hideStation(station_group.eq(3));
    } else {
      // Trạm 4 = 406 != trạm cuối
      if ($(this).val() == 406) {
        showStation(station_group.eq(3));
        if (station_end.val() == 407) {
          disabledStation(station_select.eq(3));
          unDisabledStation(station_select.eq(2));
        } else if (station_end.val() == 409) {
          station_select.eq(3).val(407);
          station_select.eq(4).val(408);
          station_select.eq(5).val(409);
          unDisabledStation(station_select.eq(2));
          unDisabledStation(station_select.eq(3));
          showStation(station_group.eq(5));
          disabledStation(station_select.eq(4));
          disabledStation(station_select.eq(5));
        } else {
          unDisabledStation(station_select.eq(2));
          unDisabledStation(station_select.eq(3));
        }
      } else {
        // Trạm 4 = 407 != trạm cuối
        if (station_end.val() == 409) {
          // trạm 4 = 407, trạm cuối = 409
          station_select.eq(3).val(408);
          station_select.eq(4).val(409);
          disabledStation(station_select.eq(3));
          disabledStation(station_select.eq(4));

          hideStation(station_group.eq(5));
        } else {
          // trạm 4 = 407, trạm cuối = 412
          station_select.eq(3).val(408);
          disabledStation(station_select.eq(3));

          // Sửa selectbox trạm 6
          hideStation(
            $(".station-select:eq(4) > option[value='408']")
          );
          station_select.eq(4).val(409);
          station_select.eq(5).val(410);
          station_select.eq(6).val(411);
          station_select.eq(7).val(412);
          unDisabledStation(station_select.eq(4));
          disabledStation(station_select.eq(5));
          disabledStation(station_select.eq(6));
          disabledStation(station_select.eq(7));
          hideStation(station_group.eq(8));
        }
      }
    }
  });

  station_select.eq(3).on("change", function () {
    if ($(this).val() == 407) {
      // Trạm 5 = 407
      if (station_end.val() == 407) {
        // Trạm 5 = trạm cuối
        disabledStation($(this));
      } else if (station_end.val() == 412) {
        // Trạm 5 khác trạm cuối (408)
        station_select.eq(4).val(408);
        showStation(station_group.eq(5));
        unDisabledStation(station_select.eq(5));
        disabledStation(station_select.eq(4));
        disabledStation(station_select.eq(6));
        hideStation($(".station-select:eq(5) > option[value='411']"));
      } else {
        // trạm cuối = 409
        station_select.eq(4).val(408);
        showStation(station_group.eq(5));
      }
    } else {
      // Trạm 5 = 408
      if (station_end.val() == 409) {
        // Trạm cuối = 409
        station_select.eq(4).val(409);
        hideStation(station_group.eq(5));
      } else {
        // Trạm cuối = 412
        station_select.eq(4).val(409);
        station_select.eq(5).val(410);
        station_select.eq(6).val(411);
        station_select.eq(7).val(412);
        disabledStation(station_select.eq(5));
        unDisabledStation(station_select.eq(4));
        hideStation($(".station-select:eq(4) > option[value='408']"));
        hideStation(station_group.eq(8));
      }
    }
  });

  station_select.eq(4).on("change", function () {
    // trạm 6
    if ($(this).val() == 409) {
      // Trạm 6 = 409
      if (station_end.val() == 409) {
        // Trạm 6 = 409 và trạm cuối == 409
      } else {
        // Trạm 6 = 409 và trạm cuối != 409
        station_select.eq(5).val(410);
        station_select.eq(6).val(411);
        showStation(station_group.eq(7));
      }
    } else {
      // Trạm 6 = 410
      station_select.eq(5).val(411);
      station_select.eq(6).val(412);
      hideStation(station_group.eq(7));
    }
  });

  station_select.eq(5).on("change", function () {
    // trạm 7
    if ($(this).val() == 409) {
      if (station_end.val() == 409) {
        // Trạm 7 = 409, là trạm cuối
      } else {
        // Trạm 7 = 409, không phải trạm cuối
        station_select.eq(6).val(410);
        station_select.eq(7).val(411);
        showStation(station_group.eq(8));
      }
    } else {
      // trạm 7 = 410
      station_select.eq(6).val(411);
      station_select.eq(7).val(412);
      hideStation(station_group.eq(8));
    }
  });

  // Reset nút station_start, station_end khi load trang
  station_start.trigger("change");
  station_end.trigger("change");
});

function disabledStation(station_disable) {
  station_disable.attr("disabled", "disabled");
}
function unDisabledStation(station_disable) {
  station_disable.removeAttr("disabled");
}
function hideStation(station_show) {
  station_show.hide();
}
function showStation(station_hide) {
  station_hide.show();
}
function hideAllStation(station_group) {
  station_group.each(function () {
    $(this).hide();
  });
}

