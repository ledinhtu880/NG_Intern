<div class="navbar-custom bg-white">
    <div class="app-search">
        <!--  <form>
      <div class="input-group">
        <span class="app-search-icon"><i class="fa-solid fa-search"></i></span>
        <input type="text" class="form-control rounded-0 rounded-start-1" placeholder="Tìm kiếm..." id="top-search">
        <div class="input-group-append">
          <button class="btn btn-primary rounded-0 rounded-end-1" type="submit">Tìm kiếm</button>
        </div>
      </div>
    </form> -->
    </div>
    <ul class="d-flex list-unstyled m-0 p-0">
        <li class="dropdown notification-list">
            <button type="button" class="nav-link dropdown-toggle h-100" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <img src="{{ asset('images/flags/vn.png') }}" alt="vn-img" class="me-0 me-sm-1" height="12">
                <span class="align-middle d-none d-sm-inline-block">Tiếng Việt</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end overflow-hidden mt-0 py-0">
                <!-- item-->
                <a href="#" class="dropdown-item py-2 d-block">
                    <img src="{{ asset('images/flags/us.jpg') }}" alt="us-image" class="me-1" height="12">
                    <span class="align-middle">English</span>
                </a>
            </div>
        </li>
        <li class="dropdown notification-list">
            <a class="nav-link nav-user py-3 px-2" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="d-flex flex-column ms-1 text-start">
                    <span class="account-user-name">{{ session('name') }}</span>
                    <!-- <span class="account-position">Quản trị viên</span> -->
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end m-0">
                <li>
                    <a href="#" class="dropdown-item py-2">
                        <h6 class="text-overflow m-0">Chào mừng</h6>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-item" id="logout">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
