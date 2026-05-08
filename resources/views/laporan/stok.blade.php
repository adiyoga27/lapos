@extends('layouts.master')

@section('title', 'Laporan Stok Barang')

@section('content')
<h4 class="mb-3">Laporan Stok Barang</h4>

<div x-data="laporanStok()" x-init="loadData()">
    <div class="card mb-3">
        <div class="card-body">
            <form @submit.prevent="loadData()" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Cari Barang</label>
                    <input type="text" x-model="search" placeholder="Kode / Nama Barang..." class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Kategori</label>
                    <select x-model="kategoriFilter" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->kode }}">{{ $kat->nama ?? $kat->kode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
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

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th class="text-end">Stok Toko</th>
                        <th class="text-end">Stok Gudang</th>
                        <th class="text-end">HPP</th>
                        <th class="text-end">Harga Toko</th>
                        <th class="text-end">Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, i) in items" :key="item.kode">
                        <tr :class="(item.toko || 0) <= (item.stokmin || 0) ? 'table-danger' : ''">
                            <td><code x-text="item.kode"></code></td>
                            <td x-text="item.nama"></td>
                            <td x-text="item.kategori_nama || '-'"></td>
                            <td x-text="item.satuan || 'PCS'"></td>
                            <td class="text-end">
                                <span :class="(item.toko || 0) <= (item.stokmin || 0) ? 'text-danger fw-bold' : ''"
                                      x-text="item.toko"></span>
                            </td>
                            <td class="text-end" x-text="item.gudang || 0"></td>
                            <td class="text-end" x-text="formatRupiah(item.hpp)"></td>
                            <td class="text-end" x-text="formatRupiah(item.harga_toko)"></td>
                            <td class="text-end fw-medium" x-text="formatRupiah((item.toko || 0) * (item.hpp || 0))"></td>
                        </tr>
                    </template>
                    <tr x-show="items.length === 0">
                        <td colspan="9" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                </tbody>
                <tfoot x-show="items.length > 0" class="table-light">
                    <tr>
                        <td colspan="8" class="text-end fw-bold">Total Nilai Stok:</td>
                        <td class="text-end fw-bold text-primary" x-text="formatRupiah(totalNilai)"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div x-show="items.length > 0 && hasLowStock()" class="alert alert-danger mt-3">
        <i class="fa-solid fa-triangle-exclamation me-1"></i> Barang yang disorot merah memiliki stok di bawah batas minimum.
    </div>
</div>
@endsection

@section('script-bottom')
<script>
    function laporanStok() {
        return {
            search: '',
            kategoriFilter: '',
            items: [],
            totalNilai: 0,

            async loadData() {
                try {
                    var params = '?';
                    if (this.search) params += 'search=' + encodeURIComponent(this.search) + '&';
                    if (this.kategoriFilter) params += 'kategori=' + this.kategoriFilter;
                    var res = await fetch('/api/laporan-stok' + params);
                    var data = await res.json();
                    if (data.success) {
                        this.items = data.data || [];
                        this.totalNilai = this.items.reduce(function(sum, item) {
                            return sum + ((item.toko || 0) * (item.hpp || 0));
                        }, 0);
                    }
                } catch (e) {}
            },

            hasLowStock() {
                return this.items.some(function(item) { return (item.toko || 0) <= (item.stokmin || 0); });
            },

            printReport() { window.print(); },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },
        }
    }
</script>
@endsection