<div class="left-side-menu vh-100">
  <div class="d-flex flex-column align-items-stretch flex-shrink-0 h-100">
    <!-- - Start: Nav Header -->
    <div class="p-3">
      <div class="text-center mb-4">
        <a href="{{ route('index') }}" class="text-center">
          <img src="{{ asset('images/logo.jpg') }}" alt="" height="55" class="object-fit-cover">
        </a>
      </div>
    </div>
    <!-- - End: Nav Header -->
    <nav class="p-3 h-100 overflow-y-auto">
      <ul class="side-nav px-2">
        <li class="side-nav-title">Điều hướng</li>
        <li class="side-nav-item">
          <a href="{{ route('index') }}" class="btn btn-toggle rounded border-0">Home</a>
        </li>
        <li class="side-nav-title">Quản lý</li>
        <li class="side-nav-item">
          <button class="btn btn-toggle collapsed rounded border-0" data-bs-toggle="collapse"
            data-bs-target="#management-collapsed" aria-expanded="false">
            Đơn giao hàng
            <span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </button>
          <div class="collapse" id="management-collapsed">
            <ul class="btn-toggle-nav list-unstyled fw-normal d-flex flex-column gap-2">
              <li><a class="text-decoration-none text-muted" href="{{ route('customers.index') }}">Quản lý khách
                  hàng</a></li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('rawMaterials.index') }}">
                  Quản lý nguyên liệu
                </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('orders.simples.index') }}">
                  Quản lý đơn thùng hàng
                </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('orders.packs.index') }}">
                  Quản lý đơn gói hàng
                </a>
              </li>
              <li><a class="text-decoration-none text-muted" href="{{ route('wares.index') }}">Quản lý kho hàng</a></li>
              <li><a class="text-decoration-none text-muted" href="{{ route('stations.index') }}">Quản lý trạm</a></li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('productStationLines.index') }}">
                  Quản lý xử lý dây chuyền
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="side-nav-item">
          <button class="btn btn-toggle collapsed rounded border-0" data-bs-toggle="collapse"
            data-bs-target="#local-collapsed" aria-expanded="false">
            Đơn nội bộ
            <span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </button>
          <div class="collapse" id="local-collapsed">
            <ul class="btn-toggle-nav list-unstyled fw-normal d-flex flex-column gap-2">
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('orderLocals.makes.index') }}">Quản lý đơn
                  sản xuất
                </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('orderLocals.packs.index') }}">
                  Quản lý đơn đóng gói
                </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('orderLocals.expeditions.index') }}">
                  Quản lý đơn giao hàng
                </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('dispatch.index') }}">
                  Khởi động đơn hàng
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="side-nav-item">
          <button class="btn btn-toggle collapsed rounded border-0" data-bs-toggle="collapse"
            data-bs-target="#tracking-collapsed" aria-expanded="false">
            Theo dõi
            <span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </button>
          <div class="collapse" id="tracking-collapsed">
            <ul class="btn-toggle-nav list-unstyled fw-normal d-flex flex-column gap-2">
              <li><a class="text-decoration-none text-muted" href="{{ route('tracking.orders.index') }}"> Theo dõi đơn
                  hàng
                </a></li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('tracking.customers.index') }}">
                  Theo dõi khách hàng </a>
              </li>
              <li>
                <a class="text-decoration-none text-muted" href="{{ route('tracking.orderlocals.index') }}">
                  Theo dõi đơn hàng nội bộ
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="side-nav-item">
          <button class="btn btn-toggle collapsed rounded border-0" data-bs-toggle="collapse"
            data-bs-target="#system-collapsed" aria-expanded="false">
            Hệ thống
            <span class="menu-arrow"><i class="fa-solid fa-chevron-right"></i></span>
          </button>
          <div class="collapse" id="system-collapsed">
            <ul class="btn-toggle-nav list-unstyled fw-normal d-flex flex-column gap-2">
              <li><a class="text-decoration-none text-muted" href="{{ route('roles.index') }}">Quản lý vai trò</a></li>
              <li>
                <a class="text-decoration-none text-muted" id="hello" href="{{ route('users.index') }}">Quản lý người
                  dùng</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>