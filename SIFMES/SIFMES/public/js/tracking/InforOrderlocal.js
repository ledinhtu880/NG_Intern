$("document").ready(function () {
    $("#orderlocal_type").change(function () {
        var type_orderlocal = $(this).val();
        $.ajax({
            url: "/tracking/orderlocals/",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                Type_orderlocal: type_orderlocal,
            },
            success: function (response) {
                // Hiển thị danh sách đơn hàng nội bộ
                htmls = ``;
                $.each(response.orderlocals, function (index, value) {
                    let Id_OrderLocal = value.Id_OrderLocal;
                    let Date_Delivery = value.Date_Delivery;
                    let Count = value.Count;
                    let Date_Start = value.Date_Start;
                    let Date_Fin =
                        value.Date_Fin === null
                            ? "Chưa hoàn thành"
                            : formatDate(value.Date_Fin);
                    let check = value.SimpleOrPack;
                    let SimpleOrPack = check == 0 ? "Thùng hàng" : "Gói hàng";
                    let route =
                        value.SimpleOrPack == 1
                            ? `/tracking/orderlocals/detailPacks/${Id_OrderLocal}`
                            : `/tracking/orderlocals/detailSimples/${Id_OrderLocal}`;
                    htmls += `
                    <tr>
                        <td class="text-center align-middle ">${Id_OrderLocal}</td>
                        <td class="text-center align-middle ">${SimpleOrPack}</td>
                        <td class="text-center align-middle ">${Count}</td>
                        <td class="text-center align-middle ">${formatDate(
                            Date_Start
                        )}</td>
                        <td class="text-center align-middle ">${formatDate(
                            Date_Delivery
                        )}</td>
                        <td class="text-center align-middle ">${Date_Fin}</td>
                        
                        <td class="text-center align-middle ">
                            <a href="${route}" class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail"><i class="fa-solid fa-eye"></i></a>
                         </td>
                    </tr>
                    `;
                });
                $(".order-infor").html(htmls);
            },
            error: function (err) {
                console.log(err.responseText);
            },
        });
    });

    $("#orderlocal_type").change();
});
