<div class="left-side-menu">
    <nav class="sidebar-wrapped px-4 py-1">
        <div class="sidebar">
            <div class="sidebar-group">
                <a class="sidebar-item{{ request()->is('/') ? ' active' : '' }}" href="{{ route('index') }}">
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Đơn giao hàng</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/customers')) ? ' active' : '' }}"
                    href="{{ route('customers.index') }}">
                    <span>Quản lý khách hàng</span>
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/rawMaterials')) ? ' active' : '' }}"
                    href="{{ route('rawMaterials.index') }}">
                    Quản lý nguyên liệu
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orders/simples')) ? ' active' : '' }}"
                    href="{{ route('orders.simples.index') }}">
                    Quản lý đơn thùng hàng
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orders/packs')) ? ' active' : '' }}"
                    href="{{ route('orders.packs.index') }}">
                    Quản lý đơn gói hàng
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/wares')) ? ' active' : '' }}"
                    href="{{ route('wares.index') }}">Quản lý
                    kho
                    hàng</a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/stations')) ? ' active' : '' }}"
                    href="{{ route('stations.index') }}">Quản
                    lý
                    trạm</a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/productStationLines')) ? ' active' : '' }}"
                    href="{{ route('productStationLines.index') }}">
                    Quản lý xử lý dây chuyền
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Đơn nội bộ</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orderLocals/makes')) ? ' active' : '' }}"
                    href="{{ route('orderLocals.makes.index') }}">Quản
                    lý đơn
                    sản xuất
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orderLocals/packs')) ? ' active' : '' }}"
                    href="{{ route('orderLocals.packs.index') }}">
                    Quản lý đơn đóng gói
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orderLocals/expeditions')) ? ' active' : '' }}"
                    href="{{ route('orderLocals.expeditions.index') }}">
                    Quản lý đơn giao hàng
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/dispatchs')) ? ' active' : '' }}"
                    href="{{ route('dispatchs.index') }}">
                    Khởi động đơn hàng
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Theo dõi</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/tracking/orders')) ? ' active' : '' }}"
                    href="{{ route('tracking.orders.index') }}">
                    Theo dõi đơn hàng
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/tracking/customers')) ? ' active' : '' }}"
                    href="{{ route('tracking.customers.index') }}">
                    Theo dõi khách hàng
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/tracking/orderlocals')) ? ' active' : '' }}"
                    href="{{ route('tracking.orderlocals.index') }}">
                    Theo dõi đơn hàng nội bộ
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Hệ thống</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/roles')) ? ' active' : '' }}"
                    href="{{ route('roles.index') }}">
                    Quản lý vai trò
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/users')) ? ' active' : '' }}"
                    href="{{ route('users.index') }}">
                    Quản lý người dùng
                </a>
            </div>
        </div>
    </nav>
</div>
