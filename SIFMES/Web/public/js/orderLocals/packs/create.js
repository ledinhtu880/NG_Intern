$(document).ready(function () {
  const token = $("meta[name='csrf-token']").attr("content");
  const toastLiveExample = $("#liveToast");
  const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));

  let currentBgColorClass, currentIconClass;

  toastLiveExample.on('hidden.bs.toast', function () {
    $(".toast-body").removeClass(currentBgColorClass);
    $("#icon").removeClass(currentIconClass);
    $("#toast-msg").html('');
  });

  function showToast(message, bgColorClass, iconClass) {
    // Lưu trữ giá trị của tham số trong biến toàn cục
    currentBgColorClass = bgColorClass;
    currentIconClass = iconClass;

    $(".toast-body").addClass(bgColorClass);
    $("#icon").addClass(iconClass);
    $("#toast-msg").html(message);
    toastBootstrap.show();
  }

  let slBox_CustomerType = $("#FK_Id_CustomerType");

  slBox_CustomerType.on("change", function () {
    let idCustomerType = $(this).val();
    $.ajax({
      url: "/orderLocals/packs/showSimple",
      data: {
        _token: token,
        idCustomerType: idCustomerType,
      },
      type: "POST",
      success: function (response) {
        $("#table-data").html(response);
      },
    });
    $.ajax({
      url: "/orderLocals/packs/showOrderLocal",
      data: {
        _token: token,
        idCustomerType: idCustomerType,
      },
      type: "POST",
      success: function (response) {
        $("#table-result").html(response);
      },
    });
  });

  slBox_CustomerType.change();

  $("#addBtn").on("click", function () {
    let Id_ContentPack = $(".Id_ContentPack");
    let Id_ContentPacks = [];
    let Date_Delivery = $("#Date_Delivery").val();
    let checkBoxAdd = $(".checkbox-add");
    for (let i = 0; i < Id_ContentPack.length; i++) {
      if (checkBoxAdd.eq(i).prop("checked")) {
        Id_ContentPacks.push(Id_ContentPack.eq(i).html());
      }
    }
    if (Id_ContentPacks.length == 0) {
      showToast(
        "Vui lòng chọn ít nhất 1 gói",
        "bg-warning",
        "fa-exclamation-circle"
      );
      return;
    }
    $.ajax({
      url: "/orderLocals/packs/store",
      type: "POST",
      data: {
        _token: token,
        Id_ContentPacks: Id_ContentPacks,
        Date_Delivery: Date_Delivery,
      },
      success: function (response) {
        // $("#table-result").append(response);
        showToast("Thêm thành công", "bg-success", "fa-check-circle");
        slBox_CustomerType.change();
      },
      error: function (xhr) {
        console.log(xhr.responseText);
      },
    });
  });

  $("#deleteBtn").on("click", function () {
    let checkRemove = $(".check-remove");
    let Id_OrderLocals = [];
    for (let i = 0; i < checkRemove.length; i++) {
      if (checkRemove.eq(i).prop("checked")) {
        Id_OrderLocals.push($(".Id_OrderLocal").eq(i).html());
      }
    }
    for (let i = 0; i < Id_OrderLocals.length; i++) {
      Id_OrderLocals[i] = Id_OrderLocals[i].replace(/\s/g, "");
    }
    if (Id_OrderLocals.length == 0) {
      showToast(
        "Vui lòng chọn ít nhất 1 đơn đóng gói",
        "bg-warning",
        "fa-exclamation-circle"
      );
      return;
    }
    $.ajax({
      url: "/orderLocals/packs/delete",
      type: "POST",
      data: {
        _token: token,
        Id_OrderLocals: Id_OrderLocals,
      },
      success: function (response) {
        if (response.flag == true) {
          showToast(
            "Đơn hàng đã được khởi động, không thể xóa",
            "bg-warning",
            "fa-exclamation-circle"
          );
        } else {
          showToast(
            "Đơn hàng đã được khởi động, không thể xóa",
            "bg-warning",
            "fa-exclamation-circle"
          );
          $("#table-result").html(response.data);
          slBox_CustomerType.change();
        }
      },
    });
  });
});

$(document).on("click", ".btnShow", function () {
  let id_OrderLocal = $(this).data("id");
  $.ajax({
    url: "/orderLocals/packs/show",
    type: "POST",
    data: {
      _token: $("meta[name='csrf-token']").attr("content"),
      id_OrderLocal: id_OrderLocal,
    },
    success: function (response) {
      console.log(response);
      $(".table-simples").html(response);
    },
  });
});
