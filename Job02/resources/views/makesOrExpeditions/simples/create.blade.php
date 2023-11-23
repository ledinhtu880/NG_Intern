@extends('layouts.master')

@section('title', 'Tạo đơn sản xuất thùng hàng')

@section('content')
<div class="container">
  <div class="row pb-5">
    <div class="col-md-12 d-flex justify-content-center">
      <div class="w-75">
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Order lines</h4>
          </div>
          <div class="card-body px-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Mã đơn hàng</th>
                  <th class="text-center" scope="col">Khách hàng</th>
                  <th class="text-center" scope="col">Thùng chứa</th>
                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                  <th class="text-center" scope="col">Đơn giá thùng chứa</th>
                </tr>
              </thead>
              <tbody id="table-data">
                @foreach($data as $each)
                <tr>
                  <td class="d-flex justify-content-center" data-id="Id_SimpleContent"
                    data-value="{{ $each->Id_SimpleContent }}">
                    <input type="checkbox" class="form-check" name="firstFormCheck"
                      id="firstFormCheck-{{ $each->Id_SimpleContent }}">
                  </td>
                  <td data-id="Id_Order" data-value="{{ $each->Id_Order }}" class="text-center">{{ $each->Id_Order }}
                  </td>
                  <td data-id="Name_Customer" data-value="{{ $each->Name_Customer }}" class="text-center text-truncate"
                    style="max-width: 150px; width: 150px;">
                    {{ $each->Name_Customer }}
                  </td>
                  <td data-id="Name_ContainerType" data-value="{{ $each->Name_ContainerType }}" class="text-center">{{
                    $each->Name_ContainerType }}
                  </td>
                  <td data-id="Count_Container" data-value="{{ $each->Count_Container }}" class="text-center">{{
                    $each->Count_Container }}</td>
                  <td data-id="Price_Container" data-value="{{ $each->Price_Container }}" class="text-center">
                    {{ number_format($each->Price_Container, 0, ',', '.') }} VNĐ
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex align-content-center justify-content-between">
              <button type="submit" class="btn btn-primary-color px-3" id="addBtn">
                <i class="fa-solid fa-plus text-white me-2"></i>Thêm
              </button>
              <div class="input-group" style="width: 300px;">
                <label class="input-group-text bg-secondary-subtle" for="DateDilivery">
                  Ngày giao hàng
                </label>
                <input type="date" name="DateDilivery" id="DateDilivery" class="form-control"
                  value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header p-0 overflow-hidden">
            <h4 class="card-title m-0 bg-primary-color p-3">Đơn sản xuất thùng hàng</h4>
          </div>
          <div class="card-body px-0">
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th class="text-center" scope="col">Chọn</th>
                  <th class="text-center" scope="col">Mã đơn hàng</th>
                  <th class="text-center" scope="col">Số lượng</th>
                  <th class="text-center" scope="col">Mô tả</th>
                  <th class="text-center" scope="col">Ngày giao hàng</th>
                </tr>
              </thead>
              <tbody id="table-result">
                @foreach($orders as $each)
                <tr>
                  <td class="align-middle">
                    <div class="d-flex justify-content-center align-items-center">
                      <input type="checkbox" class="form-check" name="secondFormCheck"
                        id="secondFormCheck-{{ $each->Id_OrderMakeOrExpedition}}">
                    </div>
                  </td>
                  <td data-id="Id_OrderMakeOrExpedition" data-value="{{ $each->Id_OrderMakeOrExpedition }}"
                    class="text-center">
                    {{ $each->Id_OrderMakeOrExpedition }}
                  </td>
                  <td class="text-center">
                    {{ $each->Count }}
                  </td>
                  <td class="text-center">
                    <button type="button" class="btnShow btn btn-sm btn-outline-light
                      text-primary-color border-secondary" data-bs-toggle="modal"
                      data-bs-target="#show-{{ $each->Id_OrderMakeOrExpedition }}"
                      data-id="{{ $each->Id_OrderMakeOrExpedition }}">
                      <i class="fa-solid fa-eye"></i>
                    </button>

                    <div class="modal fade" id="show-{{ $each->Id_OrderMakeOrExpedition }}" tabindex="-1"
                      aria-labelledby="#show-{{ $each->Id_OrderMakeOrExpedition }}Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header p-2 bg-primary-color text-start" data-bs-theme="dark">
                            <h5 class="modal-title w-100 " id="show-{{ $each->Id_OrderMakeOrExpedition }}Label">
                              Thông tin chi tiết đơn hàng số {{ $each->Id_OrderMakeOrExpedition }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-striped m-0">
                              <thead>
                                <tr>
                                  <th class="text-center" scope="col">Nguyên liệu</th>
                                  <th class="text-center" scope="col">Số lượng nguyên liệu</th>
                                  <th class="text-center" scope="col">Đơn vị</th>
                                  <th class="text-center" scope="col">Thùng chứa</th>
                                  <th class="text-center" scope="col">Số lượng thùng chứa</th>
                                  <th class="text-center" scope="col">Đơn giá</th>
                                </tr>
                              </thead>
                              <tbody class="table-simples" class="p-5"
                                data-value="{{ $each->Id_OrderMakeOrExpedition}}">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    {{ \Carbon\Carbon::parse($each->DateDilivery)->format('d/m/Y') }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @if ($orders->lastPage() > 1)
            <div class="card-footer">
              <div class="paginate">
                {{ $orders->links('pagination::bootstrap-5')}}
              </div>
            </div>
            @endif
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary-color px-3" id="deleteBtn">
              <i class="fa-solid fa-minus text-white me-2"></i>Xóa
            </button>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-end my-3 me-3">
          <a href="{{ route('makesOrExpeditions.index')}}" class="btn btn-primary-color px-4">Lưu</a>
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
<script src="{{ asset('js/makesOrExpeditions/simples/create.js') }}"></script>
@endpush