<!-- sidebar tab menu -->
<div class="sidebar px-3 py-1">
    <div class="d-flex flex-column h-100">
        <h5 class="sidebar-title mb-4 mt-2">GB<span> - GeeBin</span></h5>

        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1">
            <li><a class="m-link active" href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Pages" href="#"><i class="fa fa-user"></i> <span>User</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Pages">
                    <li><a class="ms-link" href="{{ route('user.register') }}">User Management</a></li>
                    <li><a class="ms-link" href="{{ route('role.register') }}">Roles & Permissions</a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-dashboard"></i> <span>Administration</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="{{ route('dashboard') }}">Material Management</a></li>
                    <li><a class="ms-link" href="{{ route('dashboard') }}">Parts Management</a></li>
                    <li><a class="ms-link" href="{{ route('dashboard') }}">Supplier Management</a></li>
                    <li><a class="ms-link" href="{{ route('dashboard') }}">Godown Management</a></li>
                    <li><a class="ms-link" href="{{ route('dashboard') }}">Mixing Unit </a></li>
                </ul>
            </li>
            <li><a class="m-link" href="{{ route('dashboard') }}"><i class="fa fa-dollar"></i> <span>Purchase</span></a></li>
            <li><a class="m-link" href="{{ route('dashboard') }}"><i class="fa fa-gift"></i> <span>Sales</span></a></li>
            <li class="divider mt-4 py-2 border-top"><small>REPORTS</small></li>
            <li><a class="m-link" href="{{ route('dashboard') }}"><i class="fa fa-pie-chart"></i> <span>Reports</span></a></li>
        </ul>

        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link text-primary sidebar-mini-btn">
            <span><i class="fa fa-arrow-left"></i></span>
        </button>
    </div>
</div>