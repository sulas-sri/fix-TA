<div class="sidebar-header">
    <div class="d-flex justify-content-between">
        <div class="logo">
            {{-- <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a> --}}
            <a href="#" class="sidebar-brand">
                ADMIN<span></span>
            </a>
        </div>
        <div class="toggler">
            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
    </div>
</div>
<div class="sidebar-menu" style="background-color: #031C32;">
    <ul class="menu">
        </br>
        {{-- <li class="sidebar-title">Menu</li> --}}
        <li class="sidebar-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span style="color: white;">Dashboard</span>
            </a>
        </li>

        <li class="sidebar-title"><i class="bi bi-menu-button-wide"></i></li>

        @if (auth()->check() &&
                !auth()->user()->hasRole('headmaster'))
            <li class="sidebar-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <a href="{{ route('students.index') }}" class='sidebar-link'>
                    <i class="bi bi-people-fill"></i>
                    <span style="color: white;">Data Siswa</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('school-classes.*') ? 'active' : '' }}">
                <a href="{{ route('school-classes.index') }}" class='sidebar-link'>
                    <i class="bi bi-bookmark-fill"></i>
                    <span style="color: white;">Data Kelas</span>
                </a>
            </li>

						<li class="sidebar-item {{ request()->routeIs('cash-transactions.*') ? 'active' : '' }}">
							<a href="{{ route('cash-transactions.index') }}" class='sidebar-link'>
									<i class="bi bi-cash-stack"></i>
									<span style="color: white;">Pemasukan</span>
							</a>
						</li>
            {{-- <li class="sidebar-item has-sub {{ request()->routeIs('cash-transactions.*') ? 'active' : '' }}">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-cash-stack"></i>
                    <span style="color: white;">Pemasukan</span>
                </a>
                <ul class="submenu {{ request()->routeIs('cash-transactions.*') ? 'active' : '' }}">
                    <li class="submenu-item {{ request()->routeIs('cash-transactions.index') ? 'active' : '' }}">
                        <a href="{{ route('cash-transactions.index') }}" style="color: white;">Data Pembayaran</a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('cash-transactions.filter') ? 'active' : '' }}">
                        <a href="{{ route('cash-transactions.filter') }}" style="color: white;">Filter Data</a>
                    </li>
                </ul>
            </li> --}}

						<li class="sidebar-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
							<a href="{{ route('transactions.index') }}" class='sidebar-link'>
									<i class="bi bi-cash-stack"></i>
									<span style="color: white;">Pengeluaran</span>
							</a>
					  </li>

            <li class="sidebar-item {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                <a href="{{ route('billings.index') }}" class='sidebar-link'>
                    <i class="bi bi-currency-dollar"></i>
                    <span style="color: white;">Data Tagihan</span>
                </a>
            </li>

						{{-- <li class="sidebar-item {{ request()->is('report*') ? 'active' : '' }}">
							<a href="{{ route('report.index') }}" class='sidebar-link'>
									<i class="bi bi-file-earmark-spreadsheet-fill"></i>
									<span style="color: white;">Rekapitulasi</span>
							</a>
					 </li> --}}
            <li class="sidebar-item {{ request()->routeIs('administrators.*') ? 'active' : '' }}">
                <a href="{{ route('administrators.index') }}" class='sidebar-link'>
                    <i class="bi bi-person-badge-fill"></i>
                    <span style="color: white;">User Management</span>
                </a>
            </li>

        @endif


        <li class="sidebar-item">
            <form method="POST" action="{{ route('logout') }}" id="logout">
                @csrf

                <a href="{{ route('logout') }}" class='sidebar-link'>
                    <i class="bi bi-box-arrow-left"></i>
                    <span style="color: white;">Logout</span>
                </a>
            </form>
        </li>

    </ul>
</div>
<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
