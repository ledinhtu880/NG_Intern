@extends('layouts.master')

@section('title', 'Homepage')

@section('content')
<div class="container-fluid g-0">
  <div class="row g-0">
    <div class="col-md-12 g-0">
      <div class="tabs d-flex justify-content-between">
        <div class="tab-item active">
          <h6>Quản lý</h6>
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
                <button class="btn btn-lg btn-primary-color my-1 w-50">Quản lý đơn hàng</button>
                <button class="btn btn-lg btn-primary-color my-1 w-50">Quản lý khách hàng</button>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <h2 class="h2 text-primary-color">Quản lý sản xuất và giao hàng</h2>
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
@if(session('message') && session('type'))
<div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
      <div class=" d-flex justify-content-center align-items-center gap-2">
        @if(session('type') == 'success')
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
    const toastLiveExample = $('#liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
    toastBootstrap.show();

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
@endpush