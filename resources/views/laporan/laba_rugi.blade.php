@extends('layouts.master')

@section('title', 'Laporan Laba Rugi')

@section('content')
<h4 class="mb-3">Laporan Laba Rugi</h4>

<div x-data="laporanLR()" x-init="loadData()">
    <div class="card mb-3">
        <div class="card-body">
            <form @submit.prevent="loadData()" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" x-model="tglDari" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" x-model="tglSampai" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
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

    {{-- PENDAPATAN --}}
    <div class="card mb-3">
        <div class="card-header bg-success bg-opacity-10">
            <h6 class="mb-0 text-success fw-bold">PENDAPATAN</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <span>Penjualan</span>
                <span class="fw-medium" x-text="formatRupiah(data.penjualan)">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Return Pembelian</span>
                <span class="fw-medium" x-text="formatRupiah(data.return_pembelian)">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Pemasukan Lain</span>
                <span class="fw-medium" x-text="formatRupiah(data.pemasukan_lain)">Rp 0</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span class="text-success">Total Pendapatan</span>
                <span class="text-success" x-text="formatRupiah(totalPendapatan)">Rp 0</span>
            </div>
        </div>
    </div>

    {{-- BEBAN POKOK PENJUALAN --}}
    <div class="card mb-3">
        <div class="card-header bg-warning bg-opacity-10">
            <h6 class="mb-0 text-warning fw-bold">BEBAN POKOK PENJUALAN (HPP)</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <span>Pembelian</span>
                <span class="fw-medium" x-text="formatRupiah(data.pembelian)">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Return Penjualan</span>
                <span class="fw-medium" x-text="formatRupiah(data.return_penjualan)">Rp 0</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span class="text-warning">Total HPP</span>
                <span class="text-warning" x-text="formatRupiah(totalHPP)">Rp 0</span>
            </div>
        </div>
    </div>

    {{-- LABA KOTOR --}}
    <div class="card mb-3 border-primary">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-primary fw-bold">LABA KOTOR</h6>
            <span class="fs-4 fw-bold" :class="labaKotor >= 0 ? 'text-primary' : 'text-danger'" x-text="formatRupiah(labaKotor)">Rp 0</span>
        </div>
    </div>

    {{-- BEBAN OPERASIONAL --}}
    <div class="card mb-3">
        <div class="card-header bg-danger bg-opacity-10">
            <h6 class="mb-0 text-danger fw-bold">BEBAN OPERASIONAL</h6>
        </div>
        <div class="card-body">
            <template x-for="beban in data.beban_list" :key="beban.nama">
                <div class="d-flex justify-content-between mb-2">
                    <span x-text="beban.nama"></span>
                    <span class="fw-medium" x-text="formatRupiah(beban.jumlah)">Rp 0</span>
                </div>
            </template>
            <div x-show="!data.beban_list || data.beban_list.length === 0" class="text-center text-muted py-2 small">
                Tidak ada beban operasional
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span class="text-danger">Total Beban</span>
                <span class="text-danger" x-text="formatRupiah(totalBeban)">Rp 0</span>
            </div>
        </div>
    </div>

    {{-- LABA/RUGI BERSIH --}}
    <div class="card" :class="labaBersih >= 0 ? 'border-success' : 'border-danger'">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold" :class="labaBersih >= 0 ? 'text-success' : 'text-danger'">
                LABA BERSIH
            </h6>
            <span x-show="labaBersih >= 0" class="fs-4 fw-bold text-success" x-text="formatRupiah(labaBersih)">Rp 0</span>
            <span x-show="labaBersih < 0" class="fs-4 fw-bold text-danger" x-text="formatRupiah(Math.abs(labaBersih))">Rp 0</span>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
    function laporanLR() {
        return {
            tglDari: '{{ now()->startOfMonth()->format('Y-m-d') }}',
            tglSampai: '{{ now()->format('Y-m-d') }}',
            data: {
                penjualan: 0,
                return_pembelian: 0,
                pemasukan_lain: 0,
                pembelian: 0,
                return_penjualan: 0,
                beban_list: [],
            },

            get totalPendapatan() {
                return (this.data.penjualan || 0) + (this.data.return_pembelian || 0) + (this.data.pemasukan_lain || 0);
            },

            get totalHPP() {
                return (this.data.pembelian || 0) + (this.data.return_penjualan || 0);
            },

            get labaKotor() {
                return this.totalPendapatan - this.totalHPP;
            },

            get totalBeban() {
                if (!this.data.beban_list) return 0;
                return this.data.beban_list.reduce(function(sum, b) { return sum + (b.jumlah || 0); }, 0);
            },

            get labaBersih() {
                return this.labaKotor - this.totalBeban;
            },

            async loadData() {
                try {
                    var res = await fetch('/api/laporan-laba-rugi?dari=' + this.tglDari + '&sampai=' + this.tglSampai);
                    var d = await res.json();
                    if (d.success) {
                        this.data = d.data || this.data;
                    }
                } catch (e) {}
            },

            printReport() { window.print(); },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },
        }
    }
</script>
@endsection