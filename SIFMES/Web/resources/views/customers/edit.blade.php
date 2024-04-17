@extends('layouts.master')

@section('title', 'Sửa khách hàng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('customers.index') }}">Quản lý khách hàng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold text-white m-0">
            Sửa thông tin khách hàng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <form method="POST" action="{{ route('customers.update', ['customer' => $customer]) }}"
                        id="formInformation">
                        @csrf
                        @method('PUT')
                        <h5 class="h5 fw-bold border-bottom pb-2 mb-3">Thông tin cá nhân</h5>
                        <div class="d-flex gap-2">
                            <div class="form-group flex-fill mb-3">
                                <label for="Name_Customer" class="form-label">Tên khách hàng</label>
                                <input type="text" name="Name_Customer" id="Name_Customer"
                                    placeholder="Nhập tên người dùng"
                                    class="form-control{{ $errors->has('Name_Customer') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->Name_Customer }}">
                                @if ($errors->has('Name_Customer'))
                                    <span class="text-danger">
                                        {{ $errors->first('Name_Customer') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-fill mb-3">
                                <label for="Name_Contact" class="form-label">Tên liên hệ</label>
                                <input type="text" name="Name_Contact" id="Name_Contact" placeholder="Nhập tên liên hệ"
                                    class="form-control{{ $errors->has('Name_Contact') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->Name_Contact }}">
                                @if ($errors->has('Name_Contact'))
                                    <span class="text-danger">
                                        {{ $errors->first('Name_Contact') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <h5 class="h5 fw-bold border-bottom pb-2 my-3">Thông tin liên lạc</h5>
                        <div class="d-flex gap-2">
                            <div class="form-group flex-fill mb-3">
                                <label for="Email" class="form-label">Email</label>
                                <input type="text" name="Email" id="Email" placeholder="Nhập email"
                                    class="form-control{{ $errors->has('Email') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->Email }}">
                                @if ($errors->has('Email'))
                                    <span class="text-danger">
                                        {{ $errors->first('Email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-fill mb-3">
                                <label for="Phone" class="form-label">Phone</label>
                                <input type="text" name="Phone" id="Phone" placeholder="Nhập số điện thoại"
                                    class="form-control{{ $errors->has('Phone') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->Phone }}">
                                @if ($errors->has('Phone'))
                                    <span class="text-danger">
                                        {{ $errors->first('Phone') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group flex-fill mb-3">
                                <label for="Address" class="form-label">Địa chỉ</label>
                                <input type="text" name="Address" id="Address" placeholder="Nhập địa chỉ"
                                    class="form-control{{ $errors->has('Address') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->Address }}">
                                @if ($errors->has('Address'))
                                    <span class="text-danger">
                                        {{ $errors->first('Address') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-fill mb-3">
                                <label for="Zipcode" class="form-label">Zipcode</label>
                                <input type="number" name="Zipcode" id="zipcode" placeholder="Nhập zipcode"
                                    class="form-control{{ $errors->has('Zipcode') ? ' is-invalid' : '' }}"
                                    value="{{ $customer->ZipCode }}">
                                @if ($errors->has('Zipcode'))
                                    <span class="text-danger">
                                        {{ $errors->first('Zipcode') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-group flex-fill">
                                <label for="Time_Reception" class="form-label">Thời gian tiếp
                                    nhận</label>
                                <input type="date" name="Time_Reception" id="Time_Reception"
                                    class="form-control{{ $errors->has('Time_Reception') ? ' is-invalid' : '' }}"
                                    value="{{ \Carbon\Carbon::parse($customer->Time_Reception)->format('Y-m-d') }}">
                                @if ($errors->has('Time_Reception'))
                                    <span class="text-danger">
                                        {{ $errors->first('Time_Reception') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-fill">
                                <label for="FK_Id_Mode_Transport" class="form-label">Phương
                                    thức vận
                                    chuyển</label>
                                <select name="FK_Id_Mode_Transport"
                                    class="form-select{{ $errors->has('FK_Id_Mode_Transport') ? ' is-invalid' : '' }}">
                                    @foreach ($data as $each)
                                        <option value="{{ $each->Id_ModeTransport }}"
                                            @if ($each->Id_ModeTransport == $customer->FK_Id_Mode_Transport) selected @endif>
                                            {{ $each->Name_ModeTransport }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('FK_Id_Mode_Transport'))
                                    <span class="text-danger">
                                        {{ $errors->first('FK_Id_Mode_Transport') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-fill">
                                <label for="FK_Id_CustomerType" class="form-label">Chọn kiểu
                                    khách
                                    hàng</label>
                                <select name="FK_Id_CustomerType"
                                    class="form-select{{ $errors->has('FK_Id_CustomerType') ? ' is-invalid' : '' }}">
                                    @foreach ($customerTypes as $each)
                                        <option value="{{ $each->Id }}"
                                            @if ($each->Id == $customer->FK_Id_CustomerType) selected @endif>
                                            {{ $each->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('FK_Id_CustomerType'))
                                    <span class="text-danger">
                                        {{ $errors->first('FK_Id_CustomerType') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteOrder-{{ $customer->Id_Customer }}">
                            Cập nhật
                        </button>
                        <div class="modal fade" id="deleteOrder-{{ $customer->Id_Customer }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fw-bold" id="exampleModalLabel">Xác nhận
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn cập nhật khách hàng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Xác nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            $("#saveBtn").on('click', function() {
                $("#formInformation").submit();
            })
        })
    </script>
@endpush
