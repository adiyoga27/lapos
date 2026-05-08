@extends('layouts.master')

@section('title', 'Penjualan / POS')

@section('content')
<div class="row mb-3">
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Transaksi</p>
                        <h5 id="summaryTransaksi" class="mb-0 fw-bold">0</h5>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-receipt text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Penjualan</p>
                        <h5 id="summaryJumlah" class="mb-0 fw-bold">Rp 0</h5>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-money-bill-wave text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Item Terjual</p>
                        <h5 id="summaryQty" class="mb-0 fw-bold">0</h5>
                    </div>
                    <div class="bg-secondary bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-boxes-stacked text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Piutang Kredit</p>
                        <h5 id="summaryPiutang" class="mb-0 fw-bold">Rp 0</h5>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-credit-card text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('penjualan.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <label class="form-label small">Jenis</label>
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="tunai" {{ request('jenis') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="kredit" {{ request('jenis') === 'kredit' ? 'selected' : '' }}>Kredit</option>
                    <option value="debit" {{ request('jenis') === 'debit' ? 'selected' : '' }}>Debit</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> Filter</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Penjualan</h5>
        <a href="{{ route('penjualan.create') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i> Transaksi Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualan as $item)
                    <tr>
                        <td>
                            <a href="{{ route('penjualan.show', $item->kode) }}" class="btn btn-sm btn-outline-primary me-1" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('penjualan.show', $item->kode) }}?print=1" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="Cetak"><i class="fa-solid fa-print"></i></a>
                            <form action="{{ route('penjualan.destroy', $item->kode) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi {{ $item->kode }}? Stok barang akan dikembalikan.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                        <td><code>{{ $item->kode }}</code></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->nama_pelanggan ?: 'Umum' }}</td>
                        <td class="text-end">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->jenis === 'tunai')
                                <span class="badge bg-success">Tunai</span>
                            @elseif ($item->jenis === 'debit')
                                <span class="badge bg-info text-dark">Debit</span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    Kredit
                                    @if ($item->lunas)
                                        <span class="text-success">(Lunas)</span>
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        language: {
            search: "Cari:", lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "Sebelumnya", next: "Selanjutnya" },
            zeroRecords: "Data tidak ditemukan", emptyTable: "Tidak ada data"
        }
    });

    $.get('/api/penjualan-summary?' + new URLSearchParams(window.location.search).toString(), function(data) {
        $('#summaryTransaksi').text(data.total_transaksi || 0);
        $('#summaryJumlah').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_jumlah || 0));
        $('#summaryQty').text(data.total_qty || 0);
        $('#summaryPiutang').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_piutang || 0));
    });
});
</script>
@endsection