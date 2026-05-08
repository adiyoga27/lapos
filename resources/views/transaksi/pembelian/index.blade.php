@extends('layouts.master')

@section('title', 'Pembelian')

@section('content')
<div class="row mb-3">
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Pembelian</p>
                        <h5 id="summaryTransaksi" class="mb-0 fw-bold">0</h5>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-receipt text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Nominal</p>
                        <h5 id="summaryJumlah" class="mb-0 fw-bold">Rp 0</h5>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-money-bill-wave text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Hutang</p>
                        <h5 id="summaryHutang" class="mb-0 fw-bold">Rp 0</h5>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded p-2">
                        <i class="fa-solid fa-hand-holding-dollar text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('pembelian.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <label class="form-label small">Supplier</label>
                <select name="supplier" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach ($supplierList as $sup)
                        <option value="{{ $sup->kode }}" {{ request('supplier') == $sup->kode ? 'selected' : '' }}>{{ $sup->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> Filter</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary btn-sm ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Pembelian</h5>
        <a href="{{ route('pembelian.create') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i> Pembelian Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelian as $item)
                    <tr>
                        <td>
                            <a href="{{ route('pembelian.show', $item->kode) }}" class="btn btn-sm btn-outline-primary me-1" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                            <form action="{{ route('pembelian.destroy', $item->kode) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pembelian {{ $item->kode }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                        <td><code>{{ $item->kode }}</code></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->supplierRef->nama ?? '-' }}</td>
                        <td class="text-end">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->lunas)
                                <span class="badge bg-success">Tunai</span>
                            @else
                                <span class="badge bg-warning text-dark">Kredit</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi pembelian</td>
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

    $.get('/api/pembelian-summary?' + new URLSearchParams(window.location.search).toString(), function(data) {
        $('#summaryTransaksi').text(data.total_transaksi || 0);
        $('#summaryJumlah').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_jumlah || 0));
        $('#summaryHutang').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_hutang || 0));
    });
});
</script>
@endsection