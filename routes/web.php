<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalBarang = \App\Models\Barang::count();
    $totalKategori = \App\Models\Kategori::count();
    $totalSupplier = \App\Models\Supplier::count();
    $totalPelanggan = \App\Models\Pelanggan::count();
    $totalKas = \App\Models\Kas::sum('saldo');
    $penjualanHariIni = \App\Models\Penjualan::whereDate('tanggal', now())->sum('jumlah');
    $totalPenjualan = \App\Models\Penjualan::where('jt', '0')->count();

    $stokMinim = \App\Models\Barang::where('toko', '<=', \DB::raw('stokmin'))
        ->where('stokmin', '>', 0)
        ->where('toko', '>', 0)
        ->orderBy('toko')
        ->limit(10)
        ->get(['kode', 'nama', 'toko', 'stokmin']);

    $penjualanTerakhir = \App\Models\Penjualan::where('jt', '0')
        ->orderBy('tanggal', 'desc')
        ->limit(10)
        ->get(['kode', 'tanggal', 'nama_pelanggan', 'jumlah']);

    $barangTerlaris = \App\Models\ItemPenjualan::selectRaw('itempenjualan.kode_barang, barang.nama as nama_barang, SUM(itempenjualan.qty) as total_qty')
        ->join('barang', 'barang.kode', '=', 'itempenjualan.kode_barang')
        ->groupBy('itempenjualan.kode_barang', 'barang.nama')
        ->orderByDesc('total_qty')
        ->limit(10)
        ->get();

    $pelangganTerbanyak = \App\Models\Penjualan::selectRaw('penjualan.pelanggan, pelanggan.nama as nama_pelanggan, SUM(penjualan.jumlah) as total_jumlah')
        ->join('pelanggan', 'pelanggan.kode', '=', 'penjualan.pelanggan')
        ->groupBy('penjualan.pelanggan', 'pelanggan.nama')
        ->orderByDesc('total_jumlah')
        ->limit(10)
        ->get();

    $stokLimit = \App\Models\Barang::where('stokmin', '>', 0)
        ->where('toko', '>', 0)
        ->orderBy(\DB::raw('toko / stokmin'))
        ->limit(10)
        ->get(['kode', 'nama', 'toko', 'stokmin']);

    $piutangJatuhTempo = \App\Models\Penjualan::where('jt', '>', 0)
        ->where('lunas', 0)
        ->whereRaw('DATE_ADD(tanggal, INTERVAL jt DAY) < NOW()')
        ->orderBy('tanggal')
        ->limit(10)
        ->get(['kode', 'tanggal', 'nama_pelanggan', 'jumlah', 'jt', 'lunas']);

    $hutangJatuhTempo = \App\Models\Hutang::orderBy('tanggal', 'desc')
        ->limit(10)
        ->get(['kode', 'tanggal', 'supplier', 'jumlah']);

    $labaBulanan = [];
    for ($i = 2; $i >= 0; $i--) {
        $bulan = now()->subMonths($i);
        $totalPenjualanBulan = \App\Models\Penjualan::whereYear('tanggal', $bulan->year)
            ->whereMonth('tanggal', $bulan->month)
            ->sum('jumlah');

        $totalHpp = \App\Models\ItemPenjualan::whereHas('penjualan', function ($q) use ($bulan) {
            $q->whereYear('tanggal', $bulan->year)->whereMonth('tanggal', $bulan->month);
        })->sum(\DB::raw('COALESCE(hpp, 0) * COALESCE(qty, 0)'));

        $labaBulanan[] = [
            'bulan' => $bulan->translatedFormat('M Y'),
            'penjualan' => $totalPenjualanBulan,
            'laba' => $totalPenjualanBulan - $totalHpp,
        ];
    }

    return view('dashboard', compact(
        'totalBarang', 'totalKategori', 'totalSupplier', 'totalPelanggan',
        'totalKas', 'penjualanHariIni', 'totalPenjualan',
        'stokMinim', 'penjualanTerakhir',
        'barangTerlaris', 'pelangganTerbanyak', 'stokLimit',
        'piutangJatuhTempo', 'hutangJatuhTempo', 'labaBulanan'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// Master Data Routes
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('barang', \App\Http\Controllers\Master\BarangController::class);
    Route::resource('kategori', \App\Http\Controllers\Master\KategoriController::class);
    Route::resource('supplier', \App\Http\Controllers\Master\SupplierController::class);
    Route::resource('pelanggan', \App\Http\Controllers\Master\PelangganController::class);
    Route::resource('karyawan', \App\Http\Controllers\Master\KaryawanController::class);
    Route::resource('member', \App\Http\Controllers\Master\MemberController::class);
    Route::resource('kas', \App\Http\Controllers\Master\KasController::class);
    Route::resource('biaya', \App\Http\Controllers\Master\BiayaController::class);
    Route::resource('sales', \App\Http\Controllers\Master\SalesController::class);
    Route::resource('golongan', \App\Http\Controllers\Master\GolonganController::class);
    Route::resource('area', \App\Http\Controllers\Master\AreaController::class);
    Route::resource('ukuran', \App\Http\Controllers\Master\UkuranController::class);
    Route::resource('satuan', \App\Http\Controllers\Master\SatuanController::class);
    Route::resource('pajak', \App\Http\Controllers\Master\PajakController::class);
    Route::resource('level', \App\Http\Controllers\Master\LevelController::class);
    Route::resource('kota', \App\Http\Controllers\Master\KotaController::class);
    Route::resource('warna', \App\Http\Controllers\Master\WarnaController::class);
    Route::resource('bank', \App\Http\Controllers\Master\BankController::class);
    Route::resource('permission', \App\Http\Controllers\Master\PermissionController::class)->only(['index', 'edit', 'update']);

    // ==========================================
    // Transaction Routes
    // ==========================================
    Route::resource('penjualan', \App\Http\Controllers\Transaksi\PenjualanController::class);
    Route::get('penjualan/ajax/product/{kode}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'getProduct'])->name('penjualan.product');
    Route::get('penjualan/ajax/pelanggan/{search}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'getPelanggan'])->name('penjualan.pelanggan');

    Route::resource('pembelian', \App\Http\Controllers\Transaksi\PembelianController::class);
    Route::get('pembelian/ajax/supplier/{search}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'getSupplier'])->name('pembelian.supplier');
    Route::get('pembelian/ajax/product/{kode}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'getProduct'])->name('pembelian.product');

    Route::resource('return_penjualan', \App\Http\Controllers\Transaksi\ReturnPenjualanController::class);
    Route::resource('return_pembelian', \App\Http\Controllers\Transaksi\ReturnPembelianController::class);

    // ==========================================
    // Finance Routes
    // ==========================================
    Route::resource('hutang', \App\Http\Controllers\Keuangan\HutangController::class);
    Route::resource('piutang', \App\Http\Controllers\Keuangan\PiutangController::class);
    Route::resource('pengeluaran', \App\Http\Controllers\Keuangan\PengeluaranController::class);
    Route::resource('pemasukan', \App\Http\Controllers\Keuangan\PemasukanController::class);
    Route::resource('mutasikas', \App\Http\Controllers\Keuangan\MutasikasController::class);

    // ==========================================
    // Report Routes
    // ==========================================
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/penjualan', function () { return view('laporan.penjualan'); })->name('penjualan');
        Route::get('/pembelian', function () { return view('laporan.pembelian'); })->name('pembelian');
        Route::get('/stok', function () { return view('laporan.stok'); })->name('stok');
        Route::get('/hutang-piutang', function () { return view('laporan.hutang_piutang'); })->name('hutang_piutang');
        Route::get('/kas', function () { return view('laporan.kas'); })->name('kas');
        Route::get('/laba-rugi', function () { return view('laporan.laba_rugi'); })->name('laba_rugi');
    });

    // ==========================================
    // Tool Routes
    // ==========================================
    Route::resource('absensi', \App\Http\Controllers\Tools\AbsensiController::class);
    Route::resource('voucher', \App\Http\Controllers\Tools\VoucherController::class);
    Route::get('/member/point', function () { return view('tools.member_point'); })->name('member.point');
});

require __DIR__.'/auth.php';

