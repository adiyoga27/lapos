@extends('layouts.master')

@section('title', 'Laporan Hutang Piutang')

@section('content')
<h4 class="mb-3">Laporan Hutang Piutang</h4>

<div x-data="laporanHP()" x-init="loadData()">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Tanggal</label>
                    <input type="date" x-model="tglFilter" class="form-control form-control-sm">
                </div>
                <div class="col-md-8">
                    <button @click="loadData()" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Hutang</p>
                        <h5 class="fw-bold text-danger mb-0" x-text="formatRupiah(summary.totalHutang)"></h5>
                    </div>
                    <div class="rounded bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                        <i class="fa-solid fa-hand-holding-dollar text-danger fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Piutang</p>
                        <h5 class="fw-bold text-success mb-0" x-text="formatRupiah(summary.totalPiutang)"></h5>
                    </div>
                    <div class="rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                        <i class="fa-solid fa-credit-card text-success fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Hutang Jatuh Tempo</p>
                        <h5 class="fw-bold text-warning mb-0" x-text="summary.jatuhTempoHutang || 0"></h5>
                    </div>
                    <div class="rounded bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                        <i class="fa-solid fa-calendar-xmark text-warning fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Piutang Jatuh Tempo</p>
                        <h5 class="fw-bold text-warning mb-0" x-text="summary.jatuhTempoPiutang || 0"></h5>
                    </div>
                    <div class="rounded bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                        <i class="fa-solid fa-clock text-warning fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Hutang Section --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-danger bg-opacity-10">
                    <h6 class="mb-0 text-danger fw-bold">
                        <i class="fa-solid fa-hand-holding-dollar me-1"></i> Daftar Hutang
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Supplier</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Sisa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in hutangList" :key="item.supplier">
                                <tr>
                                    <td x-text="item.supplier_nama || '-'"></td>
                                    <td class="text-end" x-text="formatRupiah(item.jumlah)"></td>
                                    <td class="text-end text-danger fw-medium" x-text="formatRupiah(item.sisa)"></td>
                                    <td>
                                        <span :class="item.status === 'Lunas' ? 'bg-success' : 'bg-danger'"
                                              class="badge" x-text="item.status"></span>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="hutangList.length === 0">
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada hutang</td>
                            </tr>
                        </tbody>
                        <tfoot x-show="hutangList.length > 0" class="table-light">
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold text-danger" x-text="formatRupiah(summary.totalHutang)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Piutang Section --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success bg-opacity-10">
                    <h6 class="mb-0 text-success fw-bold">
                        <i class="fa-solid fa-credit-card me-1"></i> Daftar Piutang
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Sisa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in piutangList" :key="item.pelanggan">
                                <tr>
                                    <td x-text="item.pelanggan_nama || '-'"></td>
                                    <td class="text-end" x-text="formatRupiah(item.jumlah)"></td>
                                    <td class="text-end text-success fw-medium" x-text="formatRupiah(item.sisa)"></td>
                                    <td>
                                        <span :class="item.status === 'Lunas' ? 'bg-success' : 'bg-danger'"
                                              class="badge" x-text="item.status"></span>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="piutangList.length === 0">
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada piutang</td>
                            </tr>
                        </tbody>
                        <tfoot x-show="piutangList.length > 0" class="table-light">
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold text-success" x-text="formatRupiah(summary.totalPiutang)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
    function laporanHP() {
        return {
            tglFilter: '{{ now()->format('Y-m-d') }}',
            hutangList: [],
            piutangList: [],
            summary: { totalHutang: 0, totalPiutang: 0, jatuhTempoHutang: 0, jatuhTempoPiutang: 0 },

            async loadData() {
                try {
                    var res = await fetch('/api/laporan-hutang-piutang?tanggal=' + this.tglFilter);
                    var data = await res.json();
                    if (data.success) {
                        this.hutangList = data.hutang || [];
                        this.piutangList = data.piutang || [];
                        this.summary = data.summary || { totalHutang: 0, totalPiutang: 0, jatuhTempoHutang: 0, jatuhTempoPiutang: 0 };
                    }
                } catch (e) {}
            },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },
        }
    }
</script>
@endsection