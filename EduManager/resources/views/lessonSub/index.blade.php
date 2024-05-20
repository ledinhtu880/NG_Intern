@extends('layouts.master')

@section('title', 'Quản lý bài học')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h3 class="h3 fw-medium">Quản lý bài học</h3>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('index') }}" class="text-decoration-none fw-medium">Trang chủ</a>
                </li>
                <li class="breadcrumb-item fw-medium active" aria-current="page">Quản lý bài học</li>
            </ol>
        </nav>
    </div>
    <div class="row g-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-transparent border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="input-group">
                                <label class="input-group-text" for="selectSubject">Chọn môn học</label>
                                <select class="form-select" id="selectSubject" name="selectSubject" tabindex="1">
                                    @foreach ($subjects as $each)
                                        <option value="{{ $each->{"Sym_Sub"} }}">{{ $each->{"Name_Sub"} }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="Id_Sub">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnCreate" data-bs-toggle="modal"
                            data-bs-target="#createSubjectModel" tabindex="2">
                            <i class="fa-solid fa-plus text-white me-1 fs-6"></i>
                            <span>Thêm bài học</span>
                        </button>
                        <div class="modal fade" id="createSubjectModel" tabindex="-1"
                            aria-labelledby="createSubjectModelLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createSubjectModelLabel">Tạo bài học</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="d-flex gap-2 mb-3">
                                                <div class="form-group" style="flex: 1">
                                                    <label for="Sym_Sub" class="form-label">Ký hiệu môn học</label>
                                                    <input type="text" name="Sym_Sub" id="Sym_Sub"
                                                        class="form-control{{ $errors->has('Sym_Sub') ? ' is-invalid' : '' }}"
                                                        value="{{ old('Sym_Sub') }}" placeholder="Nhập ký hiệu môn học"
                                                        disabled>
                                                    <span class="text-danger">
                                                        @if ($errors->has('Sym_Sub'))
                                                            {{ $errors->first('Sym_Sub') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="form-group" style="flex: 1">
                                                    <label for="Les_Unit" class="form-label">Bài học</label>
                                                    <input type="text" name="Les_Unit" id="Les_Unit"
                                                        class="form-control{{ $errors->has('Les_Unit') ? ' is-invalid' : '' }}"
                                                        value="{{ old('Les_Unit') }}" placeholder="Nhập tên bài học">
                                                    <span class="text-danger">
                                                        @if ($errors->has('Les_Unit'))
                                                            {{ $errors->first('Les_Unit') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="Les_Name" class="form-label">Tiêu đề bài học</label>
                                                <input type="text" name="Les_Name" id="Les_Name"
                                                    class="form-control{{ $errors->has('Les_Name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('Les_Name') }}" placeholder="Nhập tiêu đề bài học">
                                                <span class="text-danger">
                                                    @if ($errors->has('Les_Name'))
                                                        {{ $errors->first('Les_Name') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="d-flex gap-4">
                                                <div class="form-group" style="flex: 1">
                                                    <label for="Theory" class="form-label">Lý thuyết</label>
                                                    <input type="number" name="Theory" id="Theory"
                                                        class="form-control{{ $errors->has('Theory') ? ' is-invalid' : '' }}"
                                                        value="0" min="0">
                                                    <span class="text-danger">
                                                        @if ($errors->has('Theory'))
                                                            {{ $errors->first('Theory') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="form-group" style="flex: 1">
                                                    <label for="Exercise" class="form-label">Bài tập</label>
                                                    <input type="number" name="Exercise" id="Exercise"
                                                        class="form-control{{ $errors->has('Exercise') ? ' is-invalid' : '' }}"
                                                        value="0" min="0">
                                                    <span class="text-danger">
                                                        @if ($errors->has('Exercise'))
                                                            {{ $errors->first('Exercise') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="form-group" style="flex: 1">
                                                    <label for="Practice" class="form-label">Thực hành</label>
                                                    <input type="number" name="Practice" id="Practice"
                                                        class="form-control{{ $errors->has('Practice') ? ' is-invalid' : '' }}"
                                                        value="0" min="0">
                                                    <span class="text-danger">
                                                        @if ($errors->has('Practice'))
                                                            {{ $errors->first('Practice') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" id="saveBtn">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th scope="col" class="py-2">Ký hiệu môn học</th>
                                    <th scope="col" class="py-2">Bài học</th>
                                    <th scope="col" class="py-2">Tên bài học</th>
                                    <th scope="col" class="py-2">Lý thuyết</th>
                                    <th scope="col" class="py-2">Bài tập</th>
                                    <th scope="col" class="py-2">Thực hành</th>
                                    <th scope="col" class="py-2">Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody id="table-data"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('message') && session('type'))
        <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-{{ session('type') }} d-flex align-items-center justify-content-between">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        @if (session('type') == 'success')
                            <i class="fas fa-check-circle text-light fs-5"></i>
                        @elseif(session('type') == 'danger' || session('type') == 'warning')
                            <i class="fas fa-xmark-circle text-light fs-5"></i>
                        @elseif(session('type') == 'info' || session('type') == 'secondary')
                            <i class="fas fa-info-circle text-light fs-5"></i>
                        @endif
                        <h6 class="h6 text-white m-0">{{ session('message') }}</h6>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="toast-container rounded position-fixed bottom-0 end-0 p-3">
        <div id="toastMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center justify-content-between">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <i id="icon" class="fas text-light fs-5"></i>
                    <h6 id="toast-msg" class="h6 text-white m-0"></h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/lessonSub/index.js') }}"></script>
@endpush
