$('document').ready(function () {
    $("#orderlocal_type").change(function () {
        var type_orderlocal = $(this).val();
        $.ajax({
            url: '/tracking/orderlocals/',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                Type_orderlocal: type_orderlocal
            },
            success: function (response) {
                // Hiển thị danh sách đơn hàng nội bộ
                htmls = ``;
                $.each(response.orderlocals, function (index, value) {
                    let Id_OrderLocal = value.Id_OrderLocal;
                    let DateDilivery = value.DateDilivery;
                    let Count = value.Count;
                    let Data_Start = value.Data_Start;
                    let Data_Fin = value.Data_Fin === null ? "Chưa hoàn thành" : formatDate(value.Data_Fin);
                    let check = value.SimpleOrPack;
                    let SimpleOrPack = check == 0 ? 'Thùng hàng' : 'Gói hàng';
                    let route =
                    value.SimpleOrPack == 1
                      ? `/tracking/orderlocals/detailPacks/${Id_OrderLocal}`
                      : `/tracking/orderlocals/detailSimples/${Id_OrderLocal}`;
                    htmls += `
                    <tr>
                        <td class="text-center align-middle ">${Id_OrderLocal}</td>
                        <td class="text-center align-middle ">${SimpleOrPack}</td>
                        <td class="text-center align-middle ">${Count}</td>
                        <td class="text-center align-middle ">${formatDate(Data_Start)}</td>
                        <td class="text-center align-middle ">${formatDate(DateDilivery)}</td>
                        <td class="text-center align-middle ">${Data_Fin}</td>
                        
                        <td class="text-center align-middle ">
                            <a href="${route}" class="btn btn-sm btn-outline-light text-primary-color border-secondary btn-detail"><i class="fa-solid fa-eye"></i></a>
                         </td>
                    </tr>
                    `;
                });
                $('.order-infor').html(htmls);
            },
            error: function (err) {
                console.log(err.responseText);
            }
        });

    });

    $("#orderlocal_type").change();
});