<aside class="main-sidebar d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary shadow">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img src="https://cdn-icons-png.flaticon.com/512/2191/2191648.png" class="me-2" alt=""
            style="width: 30px; height: 24px;">
        <span class="fs-4">CTĐT</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link{{ request()->is('/') ? ' active' : ' text-dark' }}"
                aria-current="page">
                <i class="fas fa-home me-2"></i>
                Trang chủ
            </a>
        </li>
        <li>
            <a href="{{ route('eduProgram.index') }}"
                class="nav-link{{ Str::startsWith(request()->url(), url('/eduProgram')) ? ' active' : ' text-dark' }}">
                <i class="fas fa-graduation-cap me-2"></i>
                Quản lý đào tạo
            </a>
        </li>
        <li>
            <a href="{{ route('lessonSub.index') }}"
                class="nav-link{{ Str::startsWith(request()->url(), url('/lessonSub')) ? ' active' : ' text-dark' }}">
                <i class="fas fa-graduation-cap me-2"></i>
                Quản lý bài học
            </a>
        </li>
    </ul>
</aside>
