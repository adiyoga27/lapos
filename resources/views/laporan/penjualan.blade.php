@extends('layouts.master')

@section('title', 'Laporan Penjualan')

@section('content')
<h4 class="mb-3">Laporan Penjualan</h4>

<div x-data="laporanPenjualan()" x-init="loadData()">
    <div class="card mb-3">
        <div class="card-body">
            <form @submit.prevent="loadData()" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" x-model="tglDari" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" x-model="tglSampai" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Kas</label>
                    <select x-model="kasFilter" class="form-select form-select-sm">
                        <option value="">Semua Kas</option>
                        @foreach ($kasList as $kas)
                            <option value="{{ $kas->kode }}">{{ $kas->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm me-1">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                    </button>
                    <button @click="printReport()" type="button" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-print me-1"></i> Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Penjualan</p>
                    <h5 class="fw-bold mb-0" x-text="formatRupiah(summary.total)"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-1">Jumlah Transaksi</p>
                    <h5 class="fw-bold mb-0" x-text="summary.count"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-1">Rata-rata</p>
                    <h5 class="fw-bold mb-0" x-text="formatRupiah(summary.average)"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Detail Penjualan</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Pelanggan</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, i) in items" :key="item.kode">
                        <tr>
                            <td x-text="i + 1"></td>
                            <td x-text="formatDate(item.tanggal)"></td>
                            <td><code x-text="item.kode"></code></td>
                            <td x-text="item.nama_pelanggan || 'Umum'"></td>
                            <td class="text-end fw-medium" x-text="formatRupiah(item.jumlah)"></td>
                            <td>
                                <span :class="item.jenis === 'tunai' ? 'bg-success' : (item.jenis === 'debit' ? 'bg-info' : 'bg-warning text-dark')"
                                      class="badge" x-text="item.jenis"></span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="items.length === 0">
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                </tbody>
                <tfoot x-show="items.length > 0" class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                        <td class="text-end fw-bold text-primary" x-text="formatRupiah(summary.total)"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
    function laporanPenjualan() {
        return {
            tglDari: '{{ now()->startOfMonth()->format('Y-m-d') }}',
            tglSampai: '{{ now()->format('Y-m-d') }}',
            kasFilter: '',
            items: [],
            summary: { total: 0, count: 0, average: 0 },

            async loadData() {
                try {
                    var params = '?dari=' + this.tglDari + '&sampai=' + this.tglSampai;
                    if (this.kasFilter) params += '&kas=' + this.kasFilter;
                    var res = await fetch('/api/laporan-penjualan' + params);
                    var data = await res.json();
                    if (data.success) {
                        this.items = data.data || [];
                        this.summary = data.summary || { total: 0, count: 0, average: 0 };
                    }
                } catch (e) {}
            },

            printReport() { window.print(); },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },

            formatDate(dateStr) {
                if (!dateStr) return '-';
                var d = new Date(dateStr);
                return d.toLocaleDateString('id-ID');
            },
        }
    }
</script>
@endsection