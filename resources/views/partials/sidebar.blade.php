<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Home</li>
            <li class="{{ Route::is('home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            {{-- Admin --}}
            <li class="menu-header">Admin</li>
            <li class="{{ Route::is('karyawan') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('karyawan') }}">
                    <i class="fas fa-user"></i>
                    <span>Karyawan</span></a>
            </li>
            <li class="{{ Route::is('dokter') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('dokter') }}">
                    <i class="fas fa-user-md"></i>
                    <span>Dokter</span></a>
            </li>
            <li class="{{ Route::is('harga') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('harga') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Harga</span></a>
            </li>
            <li class="{{ Route::is('aturan-pakai') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('aturan-pakai') }}">
                    <i class="fas fa-sticky-note"></i>
                    <span>Aturan Pakai Obat</span></a>
            </li>
            <li class="{{ Route::is('tipe_barang') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('tipe_barang') }}">
                    <i class="fas fa-box-open"></i>
                    <span>Tipe Barang</span></a>
            </li>
            {{-- end Admin --}}

            {{-- Transaksi --}}
            <li class="menu-header">Transaksi</li>
            <li class="{{ Route::is('resep') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('resep') }}">
                    <i class="fas fa-prescription"></i>
                    <span>Resep</span></a>
            </li>
            <li class="{{ Route::is('non-resep') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('non-resep') }}">
                    <i class="fas fa-cash-register"></i>
                    <span>Non Resep</span></a>
            </li>
            <li class="{{ Route::is('laporan-transaksi') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('laporan-transaksi') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span></a>
            </li>
            {{-- Gudang --}}
            <li class="menu-header">Gudang</li>
            <li class="{{ Route::is('supplier') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('supplier') }}">
                    <i class="fas fa-truck"></i>
                    <span>Supplier</span></a>
            </li>
            <li class="{{ Route::is('product') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('product') }}">
                    <i class="fas fa-pills"></i>
                    <span>Barang</span></a>
            </li>
            <li class="{{ Route::is('faktur') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('faktur') }}">
                    <i class="fas fa-dolly"></i>
                    <span>Penerimaan Barang</span></a>
            </li>
            {{-- end Gudang --}}
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
