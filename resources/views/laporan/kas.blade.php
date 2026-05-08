@extends('layouts.master')

@section('title', 'Laporan Kas')

@section('content')
<h4 class="mb-3">Laporan Kas</h4>

<div x-data="laporanKas()" x-init="loadData()">
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
                    <p class="text-muted small mb-1">Total Pendapatan</p>
                    <h5 class="fw-bold text-success mb-0" x-text="formatRupiah(summary.totalMasuk)"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Pengeluaran</p>
                    <h5 class="fw-bold text-danger mb-0" x-text="formatRupiah(summary.totalKeluar)"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-1">Selisih</p>
                    <h5 class="fw-bold mb-0" :class="selisih >= 0 ? 'text-primary' : 'text-danger'" x-text="formatRupiah(selisih)"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Mutasi Kas</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th class="text-end">Pendapatan</th>
                        <th class="text-end">Pengeluaran</th>
                        <th class="text-end">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, i) in items" :key="i">
                        <tr>
                            <td x-text="formatDate(item.tanggal)"></td>
                            <td><code x-text="item.kode"></code></td>
                            <td>
                                <span :class="item.jenis === 'Pendapatan' ? 'bg-success' : 'bg-danger'"
                                      class="badge" x-text="item.jenis || 'Pengeluaran'"></span>
                            </td>
                            <td class="text-truncate" style="max-width:200px;" x-text="item.keterangan || '-'"></td>
                            <td class="text-end text-success fw-medium" x-text="item.masuk ? formatRupiah(item.masuk) : '-'"></td>
                            <td class="text-end text-danger fw-medium" x-text="item.keluar ? formatRupiah(item.keluar) : '-'"></td>
                            <td class="text-end fw-medium" x-text="formatRupiah(item.saldo)"></td>
                        </tr>
                    </template>
                    <tr x-show="items.length === 0">
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                </tbody>
                <tfoot x-show="items.length > 0" class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total:</td>
                        <td class="text-end fw-bold text-success" x-text="formatRupiah(summary.totalMasuk)"></td>
                        <td class="text-end fw-bold text-danger" x-text="formatRupiah(summary.totalKeluar)"></td>
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
    function laporanKas() {
        return {
            tglDari: '{{ now()->startOfMonth()->format('Y-m-d') }}',
            tglSampai: '{{ now()->format('Y-m-d') }}',
            kasFilter: '',
            items: [],
            summary: { totalMasuk: 0, totalKeluar: 0 },

            get selisih() {
                return (this.summary.totalMasuk || 0) - (this.summary.totalKeluar || 0);
            },

            async loadData() {
                try {
                    var params = '?dari=' + this.tglDari + '&sampai=' + this.tglSampai;
                    if (this.kasFilter) params += '&kas=' + this.kasFilter;
                    var res = await fetch('/api/laporan-kas' + params);
                    var data = await res.json();
                    if (data.success) {
                        this.items = data.data || [];
                        this.summary = data.summary || { totalMasuk: 0, totalKeluar: 0 };
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