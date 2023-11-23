@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
<div class="container-fluid g-0">
  <div class="row g-0">
    <div class="col-md-12 g-0">
      <div class="tabs d-flex justify-content-between">
        <div class="tab-item active">
          <h6>Quản lý</h6>
        </div>
        <div class="tab-item">
          <h6>Dây chuyền xử lý sản xuất</h6>
        </div>
        <div class="tab-item">
          <h6>Theo dõi</h6>
        </div>
        <div class="tab-item">
          <h6>Quản trị hệ thống</h6>
        </div>
        <div class="tabs-line"></div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-3">
  <div class="row">
    <div class="col-md-12">
      <div class="tab-content">
        <div class="tab-pane active">
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex flex-column">
                <a href="{{ route('makesOrExpeditions.index') }}" class="btn btn-primary-color my-1 w-50">
                  Quản lý đơn sản xuất và giao hàng
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-primary-color my-1 w-50">
                  Quản lý thùng hàng
                </a>
                <a href="{{ route('packs.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý gói hàng</a>
                <a href="{{ route('customers.index') }}" class="btn btn-primary-color my-1 w-50">
                  Quản lý khách hàng
                </a>
                <a href="{{ route('rawMaterials.index') }}" class="btn btn-primary-color my-1 w-50">
                  Quản lý nguyên liệu
                </a>
                <a href="{{ route('stations.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý trạm</a>
                <a href="{{ route('wares.index') }}" class="btn btn-primary-color my-1 w-50">Quản lý kho hàng</a>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <h2 class="h2 text-primary-color">Quản lý sản xuất và giao hàng</h2>
            </div>
          </div>
        </div>
        <div class="tab-pane">
          <div class="row">
            <div class="d-flex flex-column">
              <a href="{{ route('productionStationLines.create') }}" class="btn btn-primary-color w-25">
                Thêm dây chuyền xử lý sản xuất mới
              </a>
            </div>
            <div class="mt-2">
              <table class="table table-striped w-100">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">Tên dây chuyền</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col" class="text-center">Loại</th>
                    <th scope="col" class="text-center">Hoạt động</th>
                  </tr>
                </thead>
                <tbody id="table-data" class="table-group-divider ">
                  @foreach ($productionStationLines as $each)
                  <tr>
                    <th class="text-center" scope="col">{{ $each->Id_ProdStationLine }}</th>
                    <td>{{ $each->Name_ProdStationLine }}</td>
                    <td>{{ $each->Description }}</td>
                    <td class="text-center" scope="col">{{ $each->orderType->Name_OrderType }}</td>
                    <td class="text-center">
                      <a href="{{ route('productionStationLines.show', $each) }}"
                        class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('productionStationLines.edit', $each) }}"
                        class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                        data-bs-toggle="modal" data-bs-target="#i{{ $each->Id_ProdStationLine }}">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                      <div class="modal fade" id="i{{ $each->Id_ProdStationLine }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Bạn có chắc chắn về việc xóa dây chuyền xử lý sản xuất này?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                              <form action="{{ route('productionStationLines.destroy', $each) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
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
          </div>
        </div>
        <div class="tab-pane">
        </div>
        <div class="tab-pane">
        </div>
      </div>
    </div>
  </div>
</div>
@if (session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class=" d-flex justify-content-center align-items-center gap-2">
        @if (session('type') == 'success')
        <i class="fas fa-check-circle text-light fs-5"></i>
        @elseif(session('type') == 'danger' || session('type') == 'warning')
        <i class="fas fa-xmark-circle text-light fs-5"></i>
        @elseif(session('type') == 'info' || session('type') == 'secondary')
        <i class="fas fa-info-circle text-light fs-5"></i>
        @endif
        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@endsection

@push('javascript')
<script type="text/javascript">
  $(document).ready(function () {
    const tabs = $(".tab-item");
    const panes = $(".tab-pane");
    const tabActive = $(".tab-item.active");
    const line = $(".tabs-line");
    line.css({
      left: tabActive.position().left + "px",
      width: tabActive.outerWidth() + "px"
    });

    tabs.each(function (index) {
      let tab = $(this);
      let pane = panes.eq(index);

      tab.on("click", function () {
        $(".tab-item.active").removeClass("active");
        $(".tab-pane.active").removeClass("active");

        line.css({
          left: tab.position().left + "px",
          width: tab.outerWidth() + "px"
        });

        tab.addClass("active");
        pane.addClass("active");
      });
    });

    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();
  })

  let selectElement = $("#Id_Station");
  $(selectElement).on("change", function () {
    let id = $(this).val();
    $.ajax({
      method: "POST",
      data: {
        id: id,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      url: "/",
      // url: url,
      success: function (response) {
        let data = response.data;
        console.log(data);
        $("#table-data").empty();
        $.each(data, function (key, value) {
          let id = value.Id_ProdStationLine;
          let name = value.Name_ProdStationLine;
          let description = value.Description;
          let showUrl =
            "{{ route('productionStationLines.show', ':id') }}".replace(
              ":id",
              id
            );
          let editUrl =
            "{{ route('productionStationLines.edit', ':id') }}".replace(
              ":id",
              id
            );
          let deleteModalId = "deleteModal-" + id;
          let deleteUrl =
            "{{ route('productionStationLines.destroy', ':id') }}".replace(
              ":id",
              id
            );

          let htmls = `<tr>
                <th class="text-center" scope="row">${id}</th>
                <td>${name}</td>
                <td>${description}</td>
                <td>
                  <a href="${showUrl}" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="${editUrl}" class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary" data-bs-toggle="modal" data-bs-target="#${deleteModalId}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div class="modal fade" id="${deleteModalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc xóa dây chuyền xử lý sản xuất này?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
<form action="${deleteUrl}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>`;
          $("#table-data").append(htmls);
        });
      },
    });
  });
</script>
@endpush