$(document).ready(function () {
  $("#customer_selected").change(function () {
    var Id_Customer = $(this).val();
    $.ajax({
      url: '/tracking/customers/',
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        Id_Customer: Id_Customer
      },
      success: function (response) {
        let data = response.customer;
        // Hiển thị thông tin khách hàng
        let htmls = `
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="input-group">
                  <label for="" class="input-group-text">Mã khách hàng</label>
                  <div class="form-control">${data.Id_Customer}</div>
                </div>
              </div>
              <div class="row">
                <div class="input-group pt-3">
                  <label for="" class="input-group-text">Họ và tên</label>
                  <div class="form-control">${data.Name_Customer}</div>
                </div>
              </div>
              <div class="row">
                <div class="input-group pt-3">
                  <label for="" class="input-group-text">Tên liên lạc</label>
                  <div class="form-control">${data.Name_Contact}</div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="row">
                <div class="input-group">
                  <label for="" class="input-group-text">Email</label>
                  <div class="form-control">${data.Email}</div>
                </div>
              </div>
              <div class="row">
                <div class="input-group pt-3">
                  <label for="" class="input-group-text">Số điện thoại</label>
                  <div class="form-control">${data.Phone}</div>
                </div>
              </div>
              <div class="row">
                <div class="input-group pt-3">
                  <label for="" class="input-group-text">Địa chỉ</label>
                  <div class="form-control">${data.Address}</div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="row">
                <div class="input-group">
                  <label for="" class="input-group-text">Zipcode</label>
                  <div class="form-control">${data.ZipCode}</div>
                </div>
              </div>
              <div class="row">
              </div>
              <div class="row">
              </div>
            </div>
          </div>
        `;
        $('#customer-infor').html(htmls);
        // Hiển thị thông tin gói và vận chuyển
        htmls = `
        <div class="row">
            <div class="col">
              <div class="input-group">
                <label for="" class="input-group-text">Phương thức vận chuyển</label>
                <div class="form-control">${response.transport}</div>
              </div>
            </div>
            <div class="col">
              <div class="input-group">
                  <label for="" class="input-group-text">Kiểu khách hàng</label>
                  <div class="form-control">${response.customerType}</div>
                </div>
              </div>
          </div>
        `;
        $("#pack-transport").html(htmls);

        // Hiển thị danh sách đơn hàng
        htmls = ``;
        var count = 0;
        var Production_Status = response.percents;
        $.each(response.orders, function (index, value) {
          let Id_Order = value.Id_Order;
          let Date_Order = value.Date_Order;
          let Date_Delivery = value.Date_Dilivery;
          let Status = Production_Status[count] * 100 == 100 ? 'Đã hoàn thành' : 'Chưa hoàn thành';
          let check = value.SimpleOrPack;
          let route = check == 0 ? `/tracking/customers/detailSimples/${Id_Order}` : `/tracking/customers/detailPacks/${Id_Order}`;
          let SimpleOrPack = check == 0 ? 'Thùng hàng' : 'Gói hàng';
          htmls += `
            <tr>
              <td class="text-center align-middle ">${Id_Order}</td>
              <td class="text-center align-middle ">${Date_Order}</td>
              <td class="text-center align-middle ">${Date_Delivery}</td>
              <td class="text-center align-middle ">${Status}</td>
              <td class="align-middle ">
                <div class="d-flex justify-content-center">
                  <div class="progress w-50 position-relative" role="progressbar" aria-valuenow="${Production_Status[count] * 100}" aria-valuemin="0"
                    aria-valuemax="100" style="height: 20px">
                    <div class="progress-bar bg-primary-color" style="width: ${Production_Status[count] * 100}%">
                    </div>
                    <span class="progress-text`;
          if (Production_Status[count] * 100 >= 50) htmls += ` text-white `;
          else htmls += ` text-primary-color `;
          htmls += `fw-bold fs-6">${Production_Status[count] * 100}%</span>
                  </div>
                </div>
              </td>
              <td class="text-center align-middle">${SimpleOrPack}</td>
              <td class="text-center align-middle ">
                <a href="${route}" class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </td>
            </tr>
          `;
          count++;
        });
        $('.order-infor').html(htmls);
      },
      error: function (err) {
        console.log(err.responseText);
      }
    });

  });

  $("#customer_selected").change();
});