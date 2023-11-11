@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="tabs d-flex justify-content-between">
        <div class="tab-item active">
          <h6>Quản lý đơn nhập</h6>
        </div>
        <div class="tab-item">
          <h6>Quản lý đơn hàng</h6>
        </div>
        <div class="tabs-line"></div>
      </div>
      <div class="tab-content">
        <div class="tab-pane active">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title bg-secondary-subtle p-3 text-primary-color">Quản lý đơn nhập</h3>
              <a href="{{ route('donhang.create')}}" class="btn btn-primary-color text-white p-2">
                Thêm đơn nhập hàng
              </a>
              @if(session('message') && session('type'))
              <div class="alert alert-{{ session('type') }} mt-2">
                {{ session('message') }}
              </div>
              @endif
            </div>
            <div class="card-body">
              <table class="table table-striped w-100">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">Mã đơn hàng</th>
                    <th scope="col">Nhà cung cấp</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Ngày đặt hàng</th>
                    <th class="text-center" scope="col">Hành động</th>
                  </tr>
                </thead>
                <tbody class="table-group-divider">
                  @foreach($data as $donhang)
                  <tr>
                    <th class="text-center" scope="row">{{ $donhang->id }}</th>
                    <td>
                      {{ $donhang->getSupplierAttribute('Ten_NCC', $donhang->id)}}
                    </td>
                    <td>{{ $donhang->TrangThai }}</td>
                    <td>{{ $donhang->Ngay_DatHang }}</td>
                    <td class="text-center">
                      <a href="{{ route('donhang.show', ['donhang' => $donhang->id]) }}"
                        class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('donhang.edit', ['donhang' => $donhang->id]) }}"
                        class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                        data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $donhang->id }}">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                      <div class="modal fade" id="deleteModal-{{ $donhang->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Bạn có chắc chắn về việc xóa đơn hàng này?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form action="{{ route('donhang.destroy', ['donhang' => $donhang->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
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
            <div class="card-footer">
              <div class="paginate">
                {{ $data->links('pagination::bootstrap-5') }}
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane">
          <div class="card mt-3">
            <div class="card-header">
              <h3 class="card-title bg-secondary-subtle p-3 text-primary-color">Quản lý đơn bán</h3>
              <div class="d-flex justify-content-between align-items-center">
                <a href="" class="btn btn-primary-color text-white p-2">
                  Giao diện bán đơn hàng
                </a>
                <form>
                  <div class="form-group">
                    <input type="text" name="q" id="q" class="form-control" placeholder="Search">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
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
  })
</script>
@endsection