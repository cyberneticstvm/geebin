<!-- sidebar tab menu -->
<div class="sidebar px-3 py-1">
    <div class="d-flex flex-column h-100">
        <h5 class="sidebar-title mb-4 mt-2">GB<span> - GeeBin</span></h5>

        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1">
            <li><a class="m-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="collapsed">
                <a class="m-link {{ Route::is('user.*') ? 'active' : '' }}{{ Route::is('role.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Pages" href="#"><i class="fa fa-user"></i> <span>User</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Pages">
                    <li><a class="ms-link {{ Route::is('user.*') ? 'active' : '' }}" href="{{ route('user.register') }}">User Management</a></li>
                    <li><a class="ms-link {{ Route::is('role.*') ? 'active' : '' }}" href="{{ route('role.register') }}">Roles & Permissions</a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Route::is('branch.*') ? 'active' : '' }}{{ Route::is('company.*') ? 'active' : '' }}{{ Route::is('material.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-dashboard"></i> <span>Administration</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link {{ Route::is('branch.*') ? 'active' : '' }}" href="{{ route('branch.register') }}">Branch Management</a></li>
                    <li><a class="ms-link {{ Route::is('company.*') ? 'active' : '' }}" href="{{ route('company.register') }}">Firm Management</a></li>
                    <li><a class="ms-link {{ Route::is('material.*') ? 'active' : '' }}" href="{{ route('material.register') }}">Material Management</a></li>
                </ul>
            </li>
            <li><a class="m-link {{ Route::is('formula') ? 'active' : '' }}" href="{{ route('formula') }}"><i class="fa fa-server"></i> <span>Formula</span></a></li>

            <li><a class="m-link {{ Route::is('purchase.*') ? 'active' : '' }}" href="{{ route('purchase.register') }}"><i class="fa fa-dollar"></i> <span>Purchase</span></a></li>

            <li class="collapsed">
                <a class="m-link {{ Route::is('transfer.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-exchange"></i> <span>Transfer</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="{{ route('transfer.register', 'material') }}">Material</a></li>
                    <li><a class="ms-link" href="{{ route('transfer.register', 'parts') }}">Parts</a></li>
                    <!--<li><a class="ms-link" href="{{ route('transfer.register', 'powder') }}">Powder</a></li>-->
                    <li><a class="ms-link" href="{{ route('transfer.register', 'bag') }}">Bag</a></li>
                    <li><a class="ms-link" href="{{ route('transfer.register', 'bin') }}">Bin / Product</a></li>
                    <li><a class="ms-link {{ Route::is('transfer.pending.approval.register') ? 'active' : '' }}" href="{{ route('transfer.pending.approval.register') }}">Pending Approval</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link {{ Route::is('production.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#"><i class="fa fa-archive"></i> <span>Production</span> <span class="arrow fa fa-angle-right ms-auto text-end"></span></a>

                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="menu-Authentication">
                    <li><a class="ms-link" href="{{ route('production.register','parts') }}">Production (Parts)</a></li>
                    <li><a class="ms-link" href="{{ route('production.register', 'mixing') }}">Mixing (Powder & Liquid)</a></li>
                    <li><a class="ms-link" href="{{ route('production.register', 'bin') }}">Production (Bin)</a></li>
                    <li><a class="ms-link" href="{{ route('production.register', 'decom') }}">Production (DECOM)</a></li>
                </ul>
            </li>

            <li><a class="m-link {{ Route::is('sales.*') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-gift"></i> <span>Sales</span></a></li>

            <li class="divider mt-4 py-2 border-top"><small>REPORTS</small></li>
            <li><a class="m-link {{ Route::is('reports.*') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-pie-chart"></i> <span>Reports</span></a></li>
        </ul>

        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link text-primary sidebar-mini-btn">
            <span><i class="fa fa-arrow-left"></i></span>
        </button>
    </div>
</div>