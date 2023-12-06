@extends('layouts.master')

@section('title', 'Quản lý trạm')


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card mt-3">
        <div class="card-header px-0 pt-0 overflow-hidden">
          <h3 class="card-title bg-primary-color p-3 text-white">Quản lý trạm</h3>
          <a href="{{ route('stations.create') }}" class="btn btn-primary-color text-white p-2 my-3 ms-3">
            Thêm trạm
          </a>
        </div>
        <div class="card-body px-0">
          <table class="table table-striped w-100">
            <thead>
              <tr>
                <th class="text-center" scope="col">Mã trạm</th>
                <th scope="col">Tên trạm</th>
                <th scope="col">Địa chỉ IP</th>
                <th class="text-center" scope="col">Hành động</th>
              </tr>
            </thead>
            <tbody id="table-data" class="table-group-divider">
              @foreach ($stations as $station)
              <tr>
                <th class="text-center" scope="row">{{ $station->Id_Station }}</th>
                <td>{{ $station->Name_Station }}</td>
                <td>{{ $station->Ip_Address }}</td>
                <td class="text-center">
                  <a href="{{ route('stations.show', ['station' => $station]) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('stations.edit', ['station' => $station]) }}"
                    class="btn btn-sm btn-outline-light text-primary-color border-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a href="" class="btn btn-sm btn-outline-light text-primary-color border-secondary"
                    data-bs-toggle="modal" data-bs-target="#i{{ $station->Id_Station }}">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                  <div class="modal fade" id="i{{ $station->Id_Station }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Bạn có chắc chắn về việc xóa trạm này?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <form action="{{ route('stations.destroy', ['station' => $station]) }}" method="POST">
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
          {{-- paginate --}}
          <nav class="d-flex justify-content-end me-2">
            {{ $stations->links('pagination::bootstrap-4') }}
          </nav>
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
  const toastLiveExample = $("#liveToast");
  const toastBootstrap = new bootstrap.Toast(toastLiveExample.get(0));
  toastBootstrap.show();

  let selectElement = $("#FK_Id_StationType");
  $(selectElement).on("change", function () {
    let id = $(this).val();
    $.ajax({
      method: "POST",
      data: {
        id: id,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      url: "/showStation",
      // url: url,
      success: function (response) {
        let data = response.data;
        $("#table-data").empty();
        $.each(data, function (key, value) {
          let id = value.Id_Station;
          let name = value.Name_Station;
          let ip_address = value.Ip_Address;
          let showUrl = "{{ route('stations.show', ':id') }}"
            .replace(':id', id);
          let editUrl = "{{ route('stations.edit', ':id') }}"
            .replace(':id', id);
          let deleteModalId = "deleteModal-" + id;
          let deleteUrl = "{{ route('stations.destroy', ':id') }}"
            .replace(':id', id);

          let htmls =
            `<tr>
                <th class="text-center" scope="row">${id}</th>
                <td>${name}</td>
                <td>${ip_address}</td>
                <td class="text-center">
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
                          Bạn có chắc chắn về việc xóa trạm này?
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
      }
    });
  });
</script>
@endpush