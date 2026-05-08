@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css')
<style>
    .stat-card { border-left: 4px solid; transition: transform 0.15s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .stat-card.primary { border-left-color: #556ee6; }
    .stat-card.success { border-left-color: #34c38f; }
    .stat-card.warning { border-left-color: #f1b44c; }
    .stat-card.danger { border-left-color: #f46a6a; }
    .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .stat-card.primary .stat-icon { background: rgba(85,110,230,0.12); color: #556ee6; }
    .stat-card.success .stat-icon { background: rgba(52,195,143,0.12); color: #34c38f; }
    .stat-card.warning .stat-icon { background: rgba(241,180,76,0.12); color: #f1b44c; }
    .stat-card.danger .stat-icon { background: rgba(244,106,106,0.12); color: #f46a6a; }
</style>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Total Barang</p>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalBarang, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Penjualan Hari Ini</p>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-cash-register"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Total Pelanggan</p>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalPelanggan, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Total Supplier</p>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalSupplier, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-truck"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fa-solid fa-chart-bar me-2 text-primary"></i>Laba 3 Bulan Terakhir</h5>
                <div style="height:300px;"><canvas id="chartLaba"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fa-solid fa-boxes-stacked me-2 text-warning"></i>Stok Barang Limit</h5>
                @forelse($stokLimit as $item)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-semibold small">{{ $item->nama }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Stok: {{ $item->toko }} / Min: {{ $item->stokmin }}</div>
                    </div>
                    <span class="badge bg-danger">{{ max($item->toko - $item->stokmin, 0) == 0 ? 'Kurang' : '+' . ($item->toko - $item->stokmin) }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fa-solid fa-circle-check text-success d-block fs-2 mb-2"></i>
                    Stok aman, tidak ada yang di bawah minimum
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fa-solid fa-fire me-2 text-danger"></i>10 Barang Terlaris</h5>
                @forelse($barangTerlaris as $i => $item)
                <div class="d-flex align-items-center py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                    <span class="fw-bold me-3" style="width:28px;height:28px;min-width:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;
                        @if($loop->index <= 2) background:#556ee6;color:#fff;
                        @elseif($loop->index <= 4) background:#7272f0;color:#fff;
                        @else background:#e8e8f0;color:#555;@endif
                    ">{{ $loop->index + 1 }}</span>
                    <div class="flex-grow-1 ms-1">
                        <div class="fw-semibold">{{ $item->nama_barang }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Terjual {{ number_format($item->total_qty, 0, ',', '.') }} pcs</div>
                    </div>
                    <span class="badge rounded-pill {{ $loop->index <= 2 ? 'bg-primary' : ($loop->index <= 4 ? 'bg-info' : 'bg-secondary') }}">{{ number_format($item->total_qty, 0, ',', '.') }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fa-solid fa-box-open d-block fs-2 mb-2"></i>
                    Belum ada data penjualan
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fa-solid fa-user-tie me-2 text-info"></i>10 Pelanggan Terbanyak</h5>
                @forelse($pelangganTerbanyak as $item)
                <div class="d-flex align-items-center py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                    <span class="fw-bold me-3" style="width:28px;height:28px;min-width:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;
                        @if($loop->index <= 2) background:#34c38f;color:#fff;
                        @elseif($loop->index <= 4) background:#50c878;color:#fff;
                        @else background:#e8f5e9;color:#555;@endif
                    ">{{ $loop->index + 1 }}</span>
                    <div class="flex-grow-1 ms-1">
                        <div class="fw-semibold">{{ $item->nama_pelanggan ?: 'Umum' }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Rp {{ number_format($item->total_jumlah, 0, ',', '.') }}</div>
                    </div>
                    <span class="badge rounded-pill {{ $loop->index <= 2 ? 'bg-success' : ($loop->index <= 4 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                        Rp {{ $item->total_jumlah >= 1000000 ? number_format($item->total_jumlah / 1000000, 1, ',', '.') . 'M' : number_format($item->total_jumlah, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fa-solid fa-users d-block fs-2 mb-2"></i>
                    Belum ada data pelanggan
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold mb-0"><i class="fa-solid fa-clock me-2 text-warning"></i>Piutang Jatuh Tempo</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light"><tr><th>Pelanggan</th><th>Total</th><th>Jatuh Tempo</th></tr></thead>
                        <tbody>
                            @forelse($piutangJatuhTempo as $item)
                            @php $jatuhTempo = \Carbon\Carbon::parse($item->tanggal)->addDays((int) $item->jt); @endphp
                            <tr>
                                <td>{{ $item->nama_pelanggan ?: 'Umum' }}</td>
                                <td class="text-danger fw-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td><span class="badge bg-danger">{{ $jatuhTempo->format('d/m/Y') }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada piutang jatuh tempo</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold mb-0"><i class="fa-solid fa-money-bill-transfer me-2 text-warning"></i>Hutang Jatuh Tempo</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light"><tr><th>Supplier</th><th>Total</th><th>Tanggal</th></tr></thead>
                        <tbody>
                            @forelse($hutangJatuhTempo as $item)
                            <tr>
                                <td>{{ $item->supplier }}</td>
                                <td class="text-warning fw-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada hutang jatuh tempo</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold mb-0"><i class="fa-solid fa-receipt me-2 text-success"></i>Penjualan Terbaru</h5>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Kode</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($penjualanTerakhir as $item)
                            <tr>
                                <td><code>{{ $item->kode }}</code></td>
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->nama_pelanggan ?: 'Umum' }}</td>
                                <td class="fw-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">
                                <i class="fa-solid fa-receipt d-block fs-2 mb-2 text-muted"></i>
                                Belum ada transaksi penjualan
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const defaultFont = { family: "'Segoe UI', system-ui, -apple-system, sans-serif", size: 12 };
    const gridColor = 'rgba(0,0,0,0.06)';

    // Chart: Laba 3 Bulan Terakhir
    const ctxLaba = document.getElementById('chartLaba');
    if (ctxLaba) {
        new Chart(ctxLaba, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($labaBulanan, 'bulan')) !!},
                datasets: [
                    {
                        label: 'Penjualan',
                        data: {!! json_encode(array_column($labaBulanan, 'penjualan')) !!},
                        backgroundColor: 'rgba(85, 110, 230, 0.6)',
                        borderColor: 'rgba(85, 110, 230, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                        order: 2,
                    },
                    {
                        label: 'Laba',
                        data: {!! json_encode(array_column($labaBulanan, 'laba')) !!},
                        backgroundColor: 'rgba(52, 195, 143, 0.8)',
                        borderColor: 'rgba(52, 195, 143, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                        order: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: defaultFont, usePointStyle: true, padding: 20 } },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return ctx.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw); }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: defaultFont } },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: defaultFont,
                            callback: function(v) { return v >= 1e6 ? (v/1e6).toFixed(1)+'M' : v >= 1e3 ? (v/1e3).toFixed(0)+'K' : v; }
                        },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }
});
</script>
@endsection