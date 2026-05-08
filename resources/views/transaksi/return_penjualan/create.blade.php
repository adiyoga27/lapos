@extends('layouts.master')
@section('title') Return Penjualan Baru @endsection
@section('content')
<div x-data="returnPenjualanScreen()" x-init="init()" class="container" style="max-width:960px;">
    <div x-show="flashMessage" x-text="flashMessage" x-cloak
         :class="flashType === 'success' ? 'alert alert-success' : 'alert alert-danger'"
         class="mb-3"></div>

    <div class="card mb-3">
        <div class="card-body">
            <h6 class="border-bottom pb-2 mb-3">Pilih Faktur Penjualan</h6>
            <div class="position-relative" x-data="{ showFakturDropdown: false, fakturResultsLocal: [] }">
                <input type="text" x-model="fakturSearch"
                       @input.debounce.300ms="searchFaktur(); showFakturDropdown = true"
                       @focus="if (fakturResults.length > 0) showFakturDropdown = true"
                       placeholder="Cari No. Faktur Penjualan..."
                       class="form-control form-control-lg">
                <div x-show="showFakturDropdown && fakturResults.length > 0" x-cloak
                     @click.away="showFakturDropdown = false"
                     class="position-absolute w-100 bg-white border rounded shadow" style="z-index:1050; top:100%; margin-top:4px; max-height:240px; overflow-y:auto;">
                    <template x-for="(f, i) in fakturResults" :key="f.kode">
                        <div @click="pilihFaktur(f); showFakturDropdown = false"
                             class="px-3 py-2 border-bottom" style="cursor:pointer;"
                             @mouseenter="$el.classList.add('bg-light')" @mouseleave="$el.classList.remove('bg-light')">
                            <p class="mb-0 fw-medium small" x-text="f.kode"></p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">
                                <span x-text="formatDate(f.tanggal)"></span> &bull;
                                <span x-text="f.nama_pelanggan || 'Umum'"></span> &bull;
                                <span x-text="formatRupiah(f.jumlah)"></span>
                            </p>
                        </div>
                    </template>
                </div>
            </div>
            <div x-show="selectedFaktur" class="mt-3 alert alert-info py-2 px-3 small">
                <div class="row">
                    <div class="col-sm-4">
                        <span class="text-muted" style="font-size:0.75rem;">No. Faktur</span>
                        <p class="fw-bold text-primary mb-0" x-text="selectedFaktur ? selectedFaktur.kode : ''"></p>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted" style="font-size:0.75rem;">Tanggal</span>
                        <p class="fw-medium mb-0" x-text="selectedFaktur ? formatDate(selectedFaktur.tanggal) : ''"></p>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted" style="font-size:0.75rem;">Pelanggan</span>
                        <p class="fw-medium mb-0" x-text="selectedFaktur ? (selectedFaktur.nama_pelanggan || 'Umum') : ''"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3" x-show="saleItems.length > 0">
        <div class="card-header">
            <h6 class="mb-0">Item yang Dapat Direturn</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover small mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Qty Jual</th>
                        <th class="text-center">Qty Return</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in saleItems" :key="index">
                        <tr>
                            <td class="text-muted" x-text="index + 1"></td>
                            <td class="font-monospace small text-primary" x-text="item.kode_barang"></td>
                            <td x-text="item.nama_barang"></td>
                            <td class="text-center text-muted" x-text="item.qty"></td>
                            <td class="text-center">
                                <input type="number" x-model.number="item.qty_return"
                                       min="0" :max="item.qty"
                                       @change="recalcAll()" @keyup="recalcAll()"
                                       class="form-control form-control-sm text-center" style="width:70px; display:inline-block;">
                            </td>
                            <td class="text-end" x-text="formatRupiah(item.harga)"></td>
                            <td class="text-end fw-medium" x-text="formatRupiah((item.qty_return || 0) * item.harga)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="ms-auto" style="max-width:250px;">
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total Return</span>
                    <span class="text-primary" x-text="formatRupiah(totalReturn)"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h6 class="border-bottom pb-2 mb-3">Info Return</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Tanggal Return</label>
                    <input type="date" x-model="tanggal" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Kas (Refund)</label>
                    <select x-model="kodeKas" class="form-select form-select-sm">
                        <option value="">Pilih Kas</option>
                        @foreach ($kasList as $kas)
                            <option value="{{ $kas->kode }}">{{ $kas->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label small fw-medium text-muted">Alasan / Keterangan</label>
                <textarea x-model="alasan" rows="2" class="form-control form-control-sm" placeholder="Alasan return..."></textarea>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button @click="prosesReturn()" :disabled="loading || totalReturn <= 0"
                class="btn btn-success flex-fill fw-bold d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            <span x-text="loading ? 'Memproses...' : 'PROSES RETURN'"></span>
        </button>
        <a href="{{ route('return_penjualan.index') }}" class="btn btn-danger flex-fill fw-bold d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-xmark-circle"></i> BATAL
        </a>
    </div>
</div>
@endsection
@section('script-bottom')
<script>
    function returnPenjualanScreen() {
        return {
            fakturSearch: '',
            fakturResults: [],
            showFakturDropdown: false,
            selectedFaktur: null,
            saleItems: [],
            totalReturn: 0,
            tanggal: '{{ now()->format('Y-m-d') }}',
            kodeKas: '{{ $kasList->first()->kode ?? '' }}',
            alasan: '',
            loading: false,
            flashMessage: '',
            flashType: 'success',

            init() {},

            async searchFaktur() {
                if (this.fakturSearch.length < 1) {
                    this.fakturResults = [];
                    return;
                }
                try {
                    const res = await fetch(`/penjualan/ajax/faktur/${encodeURIComponent(this.fakturSearch)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.fakturResults = data.data;
                    }
                } catch (e) {
                    this.fakturResults = [];
                }
            },

            async pilihFaktur(faktur) {
                this.selectedFaktur = faktur;
                this.fakturSearch = faktur.kode;
                try {
                    const res = await fetch(`/return_penjualan/get-items/${encodeURIComponent(faktur.kode)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.saleItems = data.data.map(item => ({ ...item, qty_return: 0 }));
                    }
                } catch (e) {
                    this.showFlash('Gagal mengambil item penjualan', 'error');
                }
            },

            recalcAll() {
                this.totalReturn = this.saleItems.reduce((sum, item) => {
                    return sum + ((item.qty_return || 0) * item.harga);
                }, 0);
            },

            async prosesReturn() {
                const items = this.saleItems.filter(item => (item.qty_return || 0) > 0);
                if (items.length === 0) {
                    this.showFlash('Pilih item yang akan direturn', 'error');
                    return;
                }
                if (!this.selectedFaktur) {
                    this.showFlash('Pilih faktur penjualan', 'error');
                    return;
                }

                this.loading = true;
                try {
                    const payload = {
                        no_faktur: this.selectedFaktur.kode,
                        tanggal: this.tanggal,
                        kode_kas: this.kodeKas,
                        alasan: this.alasan,
                        items: items.map(item => ({
                            kode_barang: item.kode_barang,
                            nama_barang: item.nama_barang,
                            qty: item.qty_return,
                            harga: item.harga,
                            satuan: item.satuan,
                        })),
                    };

                    const res = await fetch('{{ route("return_penjualan.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.showFlash('Return berhasil diproses', 'success');
                        setTimeout(() => window.location.href = '/return_penjualan/' + data.kode, 1000);
                    } else {
                        this.showFlash(data.message || 'Gagal memproses return', 'error');
                    }
                } catch (e) {
                    this.showFlash('Gagal memproses return', 'error');
                } finally {
                    this.loading = false;
                }
            },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },

            formatDate(dateStr) {
                if (!dateStr) return '-';
                const d = new Date(dateStr);
                return d.toLocaleDateString('id-ID');
            },

            showFlash(msg, type) {
                this.flashMessage = msg;
                this.flashType = type;
                setTimeout(() => this.flashMessage = '', 3000);
            },
        }
    }
</script>
@endsection