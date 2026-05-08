<nav id="sidebar" class="bg-dark">
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="text-white text-decoration-none">
            <i class="fa-solid fa-store me-2"></i>
            <span class="sidebar-text">Retail Pro</span>
        </a>
        <button class="btn btn-sm btn-outline-light d-md-none" id="sidebarClose" onclick="document.getElementById('sidebar').classList.remove('show')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="px-2 py-1">
        <ul class="nav flex-column">

            <li class="menu-title">Menu</li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
            </li>

            @permAny('barang','jasa','kas','biaya','pelanggan','member','supplier','karyawan','kategori','golongan','sales','area','kota','ukuran','warna','satuan','pajak','level','bank')
            <li class="menu-title">Data Master</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuData"><i class="fa-solid fa-box me-2"></i>Data</a>
                <div class="collapse" id="menuData">
                    <ul class="nav flex-column">
                        @perm('barang')<li class="nav-item"><a href="{{ route('barang.index') }}" class="nav-link"><i class="fa-solid fa-box-open me-2"></i>Barang</a></li>@endperm
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-wrench me-2"></i>Jasa</a></li>
                        @perm('kas')<li class="nav-item"><a href="{{ route('kas.index') }}" class="nav-link"><i class="fa-solid fa-cash-register me-2"></i>KAS</a></li>@endperm
                        @perm('biaya')<li class="nav-item"><a href="{{ route('biaya.index') }}" class="nav-link"><i class="fa-solid fa-receipt me-2"></i>Biaya</a></li>@endperm
                    </ul>
                </div>
            </li>
            @permAny('pelanggan','member')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuPelanggan"><i class="fa-solid fa-users me-2"></i>Pelanggan</a>
                <div class="collapse" id="menuPelanggan">
                    <ul class="nav flex-column">
                        @perm('pelanggan')<li class="nav-item"><a href="{{ route('pelanggan.index') }}" class="nav-link"><i class="fa-solid fa-address-book me-2"></i>Data Pelanggan</a></li>@endperm
                        @perm('member')<li class="nav-item"><a href="{{ route('member.index') }}" class="nav-link"><i class="fa-solid fa-id-card me-2"></i>Data Member</a></li>@endperm
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-building me-2"></i>Data Cabang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-piggy-bank me-2"></i>Tabungan Pelanggan</a></li>
                    </ul>
                </div>
            </li>
            @endpermAny
            @perm('supplier')<li class="nav-item"><a href="{{ route('supplier.index') }}" class="nav-link"><i class="fa-solid fa-truck me-2"></i>Supplier</a></li>@endperm
            @perm('karyawan')<li class="nav-item"><a href="{{ route('karyawan.index') }}" class="nav-link"><i class="fa-solid fa-user-tie me-2"></i>Karyawan</a></li>@endperm
            @permAny('kategori','golongan','sales','area','kota','ukuran','warna','satuan','pajak','level','bank')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLainnya"><i class="fa-solid fa-ellipsis me-2"></i>Lainnya</a>
                <div class="collapse" id="menuLainnya">
                    <ul class="nav flex-column">
                        @perm('kategori')<li class="nav-item"><a href="{{ route('kategori.index') }}" class="nav-link"><i class="fa-solid fa-tags me-2"></i>Kategori</a></li>@endperm
                        @perm('golongan')<li class="nav-item"><a href="{{ route('golongan.index') }}" class="nav-link"><i class="fa-solid fa-sitemap me-2"></i>Golongan</a></li>@endperm
                        @perm('sales')<li class="nav-item"><a href="{{ route('sales.index') }}" class="nav-link"><i class="fa-solid fa-person-walking me-2"></i>Sales</a></li>@endperm
                        @perm('area')<li class="nav-item"><a href="{{ route('area.index') }}" class="nav-link"><i class="fa-solid fa-map-location-dot me-2"></i>Area</a></li>@endperm
                        @perm('kota')<li class="nav-item"><a href="{{ route('kota.index') }}" class="nav-link"><i class="fa-solid fa-city me-2"></i>Kota</a></li>@endperm
                        @perm('ukuran')<li class="nav-item"><a href="{{ route('ukuran.index') }}" class="nav-link"><i class="fa-solid fa-ruler-combined me-2"></i>Ukuran</a></li>@endperm
                        @perm('warna')<li class="nav-item"><a href="{{ route('warna.index') }}" class="nav-link"><i class="fa-solid fa-palette me-2"></i>Warna</a></li>@endperm
                        @perm('satuan')<li class="nav-item"><a href="{{ route('satuan.index') }}" class="nav-link"><i class="fa-solid fa-ruler me-2"></i>Satuan</a></li>@endperm
                        @perm('pajak')<li class="nav-item"><a href="{{ route('pajak.index') }}" class="nav-link"><i class="fa-solid fa-percent me-2"></i>Pajak</a></li>@endperm
                        @perm('level')<li class="nav-item"><a href="{{ route('level.index') }}" class="nav-link"><i class="fa-solid fa-layer-group me-2"></i>Level Harga</a></li>@endperm
                        @perm('bank')<li class="nav-item"><a href="{{ route('bank.index') }}" class="nav-link"><i class="fa-solid fa-building-columns me-2"></i>Bank</a></li>@endperm
                    </ul>
                </div>
            </li>
            @endpermAny
            @endpermAny

            @permAny('pembelian','penjualan','return_pembelian','return_penjualan','hutang','piutang')
            <li class="menu-title">Transaksi</li>
            @perm('pembelian')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuBeli"><i class="fa-solid fa-cart-shopping me-2"></i>Beli</a>
                <div class="collapse" id="menuBeli">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('pembelian.index') }}" class="nav-link"><i class="fa-solid fa-cart-plus me-2"></i>Pembelian Langsung</a></li>
                        <li class="nav-item"><a href="{{ route('pembelian.create') }}" class="nav-link"><i class="fa-solid fa-file-invoice me-2"></i>Purchase Order (PO)</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @perm('penjualan')<li class="nav-item"><a href="{{ route('penjualan.index') }}" class="nav-link"><i class="fa-solid fa-cash-register me-2"></i>Jual</a></li>@endperm
            @permAny('return_pembelian','return_penjualan')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuReturn"><i class="fa-solid fa-rotate-left me-2"></i>Return</a>
                <div class="collapse" id="menuReturn">
                    <ul class="nav flex-column">
                        @perm('return_pembelian')<li class="nav-item"><a href="{{ route('return_pembelian.index') }}" class="nav-link"><i class="fa-solid fa-rotate-left me-2"></i>Return Pembelian</a></li>@endperm
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-box me-2"></i>Terima Return</a></li>
                        @perm('return_penjualan')<li class="nav-item"><a href="{{ route('return_penjualan.index') }}" class="nav-link"><i class="fa-solid fa-right-from-bracket me-2"></i>Return Penjualan</a></li>@endperm
                    </ul>
                </div>
            </li>
            @endpermAny
            @permAny('hutang','piutang')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuHutangPiutang"><i class="fa-solid fa-money-bill-transfer me-2"></i>Hutang Piutang</a>
                <div class="collapse" id="menuHutangPiutang">
                    <ul class="nav flex-column">
                        @perm('hutang')<li class="nav-item"><a href="{{ route('hutang.index') }}" class="nav-link"><i class="fa-solid fa-money-check me-2"></i>Bayar Hutang</a></li>@endperm
                        @perm('piutang')<li class="nav-item"><a href="{{ route('piutang.index') }}" class="nav-link"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Piutang Pelanggan</a></li>@endperm
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-building me-2"></i>Piutang Cabang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-calendar-check me-2"></i>Pembayaran Angsuran</a></li>
                    </ul>
                </div>
            </li>
            @endpermAny
            @endpermAny

            @permAny('pemasukan','pengeluaran','mutasikas','absensi','voucher')
            <li class="menu-title">Back Office</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuBackOffice"><i class="fa-solid fa-building me-2"></i>Back Office</a>
                <div class="collapse" id="menuBackOffice">
                    <ul class="nav flex-column">
                        @perm('pemasukan')<li class="nav-item"><a href="{{ route('pemasukan.index') }}" class="nav-link"><i class="fa-solid fa-arrow-down me-2"></i>Pemasukan</a></li>@endperm
                        @perm('pengeluaran')<li class="nav-item"><a href="{{ route('pengeluaran.index') }}" class="nav-link"><i class="fa-solid fa-arrow-up me-2"></i>Pengeluaran</a></li>@endperm
                        @perm('mutasikas')<li class="nav-item"><a href="{{ route('mutasikas.index') }}" class="nav-link"><i class="fa-solid fa-right-left me-2"></i>Mutasi Kas</a></li>@endperm
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-boxes-stacked me-2"></i>Koreksi Stok</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-hand me-2"></i>Pemakaian Barang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-clock-rotate-left me-2"></i>History Program</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-calculator me-2"></i>Kalkulator</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-truck-ramp-box me-2"></i>Mutasi Barang</a></li>
                        @perm('absensi')<li class="nav-item"><a href="{{ route('absensi.index') }}" class="nav-link"><i class="fa-solid fa-clipboard-check me-2"></i>Absensi</a></li>@endperm
                    </ul>
                </div>
            </li>
            @perm('voucher')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuTukarPoint"><i class="fa-solid fa-gift me-2"></i>Tukar Point</a>
                <div class="collapse" id="menuTukarPoint">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('voucher.index') }}" class="nav-link"><i class="fa-solid fa-gift me-2"></i>Tukar Point</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-arrow-right-arrow-left me-2"></i>Transfer Point</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @endpermAny

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuPengaturan"><i class="fa-solid fa-gear me-2"></i>Pengaturan</a>
                <div class="collapse" id="menuPengaturan">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-building me-2"></i>Perusahaan</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-rectangle-list me-2"></i>Footer Nota</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-rotate me-2"></i>Reset Point</a></li>
                        <li class="nav-item"><a href="{{ route('permission.index') }}" class="nav-link"><i class="fa-solid fa-shield-halved me-2"></i>Permission</a></li>
                    </ul>
                </div>
            </li>

            @permAny('laporan_pembelian','laporan_penjualan','laporan_stok','laporan_laba_rugi','laporan_kas','laporan_hutang_piutang')
            <li class="menu-title">Laporan</li>
            @perm('laporan_pembelian')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLapBeli"><i class="fa-solid fa-download me-2"></i>Pembelian</a>
                <div class="collapse" id="menuLapBeli">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('laporan.pembelian') }}" class="nav-link"><i class="fa-solid fa-calendar me-2"></i>Pembelian Periode</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-truck me-2"></i>Pembelian Supplier</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-box me-2"></i>Pembelian Barang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-rotate-left me-2"></i>Return Pembelian</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-box-open me-2"></i>Penerimaan Return</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @perm('laporan_penjualan')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLapJual"><i class="fa-solid fa-upload me-2"></i>Penjualan</a>
                <div class="collapse" id="menuLapJual">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('laporan.penjualan') }}" class="nav-link"><i class="fa-solid fa-calendar me-2"></i>Penjualan Periode</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-users me-2"></i>Penjualan By Pelanggan</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-id-card me-2"></i>Penjualan By Member</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-truck me-2"></i>Penjualan By Supplier</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @perm('laporan_stok')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLapStok"><i class="fa-solid fa-warehouse me-2"></i>Stok</a>
                <div class="collapse" id="menuLapStok">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('laporan.stok') }}" class="nav-link"><i class="fa-solid fa-boxes-stacked me-2"></i>Laporan Stok</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-clipboard-list me-2"></i>Kartu Stok</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @perm('laporan_laba_rugi')<li class="nav-item"><a href="{{ route('laporan.laba_rugi') }}" class="nav-link"><i class="fa-solid fa-coins me-2"></i>Laba Rugi</a></li>@endperm
            @perm('laporan_kas')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLapKas"><i class="fa-solid fa-wallet me-2"></i>Kas</a>
                <div class="collapse" id="menuLapKas">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('laporan.kas') }}" class="nav-link"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Laporan Kas</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-money-bill-transfer me-2"></i>Cash Flow</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @perm('laporan_hutang_piutang')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuLapHP"><i class="fa-solid fa-credit-card me-2"></i>Hutang Piutang</a>
                <div class="collapse" id="menuLapHP">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('laporan.hutang_piutang') }}" class="nav-link"><i class="fa-solid fa-file-invoice me-2"></i>Laporan Hutang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-clock-rotate-left me-2"></i>History Hutang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Laporan Piutang</a></li>
                        <li class="nav-item"><a href="#" class="nav-link nav-disabled"><i class="fa-solid fa-clock me-2"></i>History Piutang</a></li>
                    </ul>
                </div>
            </li>
            @endperm
            @endpermAny

        </ul>
    </div>
</nav>