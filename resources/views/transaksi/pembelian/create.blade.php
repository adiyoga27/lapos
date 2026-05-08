@extends('layouts.master')
@section('title') Transaksi Pembelian Baru @endsection
@section('content')
<div x-data="pembelianScreen()" x-init="init()">
    <div x-show="flashMessage" x-text="flashMessage" x-cloak
         :class="flashType === 'success' ? 'alert alert-success' : 'alert alert-danger'"
         class="mb-3"></div>

    <div class="row g-3" style="min-height: calc(100vh - 200px);">
        <div class="col-lg-7 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <div class="flex-fill position-relative">
                            <input type="text" id="barcodeInput" x-ref="barcodeInput"
                                   placeholder="Scan Barcode atau Cari Barang..."
                                   x-model="barcodeSearch"
                                   @keydown.enter.prevent="addByBarcode()"
                                   @keydown="onBarcodeKeydown($event)"
                                   class="form-control form-control-lg" autofocus autocomplete="off">
                            <div x-show="showAutocomplete && searchResults.length > 0" x-cloak
                                 @click.away="showAutocomplete = false"
                                 class="position-absolute w-100 bg-white border rounded shadow" style="z-index:1050; top:100%; margin-top:4px; max-height:288px; overflow-y:auto;">
                                <template x-for="(product, i) in searchResults" :key="product.kode">
                                    <div @click="addToCart(product); showAutocomplete = false; barcodeSearch = ''"
                                         class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="cursor:pointer;"
                                         @mouseenter="$el.classList.add('bg-light')" @mouseleave="$el.classList.remove('bg-light')">
                                        <div class="flex-fill">
                                            <p class="mb-0 small fw-medium" x-text="product.nama"></p>
                                            <p class="mb-0 text-muted" style="font-size:0.75rem;"><span x-text="product.kode"></span> &bull; Stok: <span x-text="product.stok"></span></p>
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-0 small fw-bold" x-text="formatRupiah(product.hpp || product.harga_toko)"></p>
                                            <p class="mb-0 text-primary" style="font-size:0.75rem;" x-text="product.satuan"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div x-show="showAutocomplete && searchResults.length === 0 && barcodeSearch.length > 0" x-cloak
                                 class="position-absolute w-100 bg-white border rounded shadow p-3 text-center text-muted small" style="z-index:1050; top:100%; margin-top:4px;">
                                Produk tidak ditemukan
                            </div>
                        </div>
                        <button @click="addByBarcode()" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                        </button>
                    </div>
                </div>
            </div>

            <div class="card flex-fill d-flex flex-column" style="min-height:0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fa-solid fa-truck-fast text-primary me-1"></i>Item Pembelian</h6>
                    <small class="text-muted" x-text="cart.length + ' item'"></small>
                </div>
                <div class="card-body flex-fill overflow-auto p-0">
                    <template x-if="cart.length === 0">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted py-5">
                            <i class="fa-solid fa-boxes-stacked fa-3x mb-3 text-secondary opacity-25"></i>
                            <p class="small">Scan barcode atau cari barang untuk memulai</p>
                        </div>
                    </template>
                    <template x-if="cart.length > 0">
                        <table class="table table-sm table-hover small mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="text-center" style="width:40px;">No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center" style="width:120px;">Qty</th>
                                    <th class="text-end">Harga Beli</th>
                                    <th class="text-center" style="width:100px;">Diskon</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center" style="width:40px;">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in cart" :key="index">
                                    <tr>
                                        <td class="text-center text-muted" x-text="index + 1"></td>
                                        <td class="font-monospace small text-primary" x-text="item.kode_barang"></td>
                                        <td x-text="item.nama_barang"></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <button @click="item.qty = Math.max(1, item.qty - 1); recalcItem(index)"
                                                        class="btn btn-outline-secondary btn-sm px-2 py-0">-</button>
                                                <input type="number" x-model.number="item.qty"
                                                       @change="recalcItem(index)" @keyup="recalcItem(index)"
                                                       min="1"
                                                       class="form-control form-control-sm text-center" style="width:60px;">
                                                <button @click="item.qty += 1; recalcItem(index)"
                                                        class="btn btn-outline-secondary btn-sm px-2 py-0">+</button>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <input type="text" x-model.number="item.harga"
                                                   @change="recalcItem(index)" @keyup="recalcItem(index)"
                                                   class="form-control form-control-sm text-end" style="width:100px; display:inline-block;">
                                        </td>
                                        <td class="text-center">
                                            <input type="number" x-model.number="item.diskon"
                                                   @change="recalcItem(index)" @keyup="recalcItem(index)"
                                                   min="0" step="100"
                                                   class="form-control form-control-sm text-center" style="width:90px;">
                                        </td>
                                        <td class="text-end fw-medium" x-text="formatRupiah(item.subtotal)"></td>
                                        <td class="text-center">
                                            <button @click="cart.splice(index, 1); recalcAll()"
                                                    class="btn btn-sm btn-outline-danger py-0 px-1">
                                                <i class="fa-solid fa-trash-can small"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </template>
                </div>
                <div class="card-footer" x-show="cart.length > 0">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        <div class="d-flex gap-3">
                            <div>
                                <label class="form-label small text-muted mb-1">Diskon Global (Rp)</label>
                                <input type="number" x-model.number="diskonGlobal" @change="recalcAll()" @keyup="recalcAll()"
                                       min="0" step="1000"
                                       class="form-control form-control-sm" style="width:150px;">
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="small text-muted mb-1">Total: <strong class="ms-2" x-text="formatRupiah(total)"></strong></p>
                            <p class="small text-muted mb-1">Diskon: <strong class="text-danger ms-2" x-text="'- ' + formatRupiah(diskonGlobal)"></strong></p>
                            <p class="h5 fw-bold border-top pt-2 mt-2">Grand Total: <span class="text-primary ms-2" x-text="formatRupiah(grandTotal)"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="border-bottom pb-2 mb-3">Info Pembelian</h6>
                    <div class="mb-2">
                        <label class="form-label small fw-medium text-muted mb-1">Tanggal</label>
                        <input type="datetime-local" x-model="tanggal" class="form-control form-control-sm">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-medium text-muted mb-1">No. Faktur</label>
                        <input type="text" x-model="noFaktur" readonly class="form-control form-control-sm bg-light">
                    </div>
                    <div>
                        <label class="form-label small fw-medium text-muted mb-1">Operator</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly class="form-control form-control-sm bg-light">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="border-bottom pb-2 mb-3">Supplier</h6>
                    <div class="position-relative mb-2">
                        <input type="text" x-model="supplierSearch"
                               @input.debounce.300ms="searchSupplier()"
                               placeholder="Cari supplier..."
                               class="form-control form-control-sm">
                        <div x-show="showSupplierDropdown && supplierResults.length > 0" x-cloak
                             @click.away="showSupplierDropdown = false"
                             class="position-absolute w-100 bg-white border rounded shadow" style="z-index:1050; top:100%; margin-top:4px; max-height:200px; overflow-y:auto;">
                            <template x-for="sup in supplierResults" :key="sup.kode">
                                <div @click="selectSupplier(sup)"
                                     class="px-3 py-2 border-bottom" style="cursor:pointer;"
                                     @mouseenter="$el.classList.add('bg-light')" @mouseleave="$el.classList.remove('bg-light')">
                                    <p class="mb-0 fw-medium small" x-text="sup.nama"></p>
                                    <p class="mb-0 text-muted" style="font-size:0.75rem;" x-text="sup.kode"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div x-show="selectedSupplier" class="alert alert-info py-2 px-3 small mb-0">
                        <p class="fw-medium text-primary mb-0" x-text="selectedSupplier ? selectedSupplier.nama : ''"></p>
                        <p class="mb-0" style="font-size:0.75rem;" x-text="selectedSupplier ? selectedSupplier.kode : ''"></p>
                        <button @click="selectedSupplier = null; supplierSearch = ''" class="btn btn-link btn-sm text-danger p-0 small">Hapus</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="border-bottom pb-2 mb-3">Metode Pembayaran</h6>
                    <div class="d-flex gap-3 mb-3">
                        <div class="form-check">
                            <input type="radio" x-model="jenisPembayaran" value="tunai" class="form-check-input" id="payTunai2" name="jenisPembayaran2">
                            <label class="form-check-label small" for="payTunai2">Tunai</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" x-model="jenisPembayaran" value="kredit" class="form-check-input" id="payKredit2" name="jenisPembayaran2">
                            <label class="form-check-label small" for="payKredit2">Kredit</label>
                        </div>
                    </div>
                    <div x-show="jenisPembayaran === 'tunai'" class="mb-2">
                        <label class="form-label small fw-medium text-muted mb-1">Kas / Akun</label>
                        <select x-model="kodeKas" class="form-select form-select-sm">
                            <option value="">Pilih Kas</option>
                            @foreach ($kasList as $kas)
                                <option value="{{ $kas->kode }}">{{ $kas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="jenisPembayaran === 'tunai'" class="mb-2">
                        <label class="form-label small fw-medium text-muted mb-1">Jumlah Bayar (Rp)</label>
                        <input type="number" x-model.number="bayar" @keyup="hitungKembali()"
                               min="0"
                               class="form-control form-control-lg fw-bold border-primary">
                    </div>
                    <div x-show="jenisPembayaran === 'tunai'">
                        <div class="bg-light rounded p-2">
                            <p class="small text-muted mb-0">Kembali</p>
                            <p class="h4 fw-bold mb-0" :class="kembali >= 0 ? 'text-success' : 'text-danger'" x-text="formatRupiah(kembali)"></p>
                        </div>
                    </div>
                    <div x-show="jenisPembayaran === 'kredit'" class="mt-2">
                        <label class="form-label small fw-medium text-muted mb-1">Jatuh Tempo</label>
                        <input type="date" x-model="jatuhTempo" class="form-control form-control-sm">
                        <div class="alert alert-warning py-2 px-3 small mt-2 mb-0">
                            <i class="fa-solid fa-circle-info me-1"></i> Transaksi akan dicatat sebagai hutang
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button @click="prosesTransaksi()" :disabled="loading || cart.length === 0"
                        class="btn btn-success btn-lg fw-bold d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-check-circle"></i>
                    <span x-text="loading ? 'Memproses...' : 'SIMPAN'"></span>
                </button>
                <button @click="batalTransaksi()"
                        class="btn btn-danger btn-lg fw-bold d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-xmark-circle"></i> BATAL
                </button>
            </div>
        </div>
    </div>

    <div x-show="showSuccessModal" x-cloak class="modal d-block" style="z-index:1060; background:rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-check-circle text-success fa-3x"></i>
                    </div>
                    <h5 class="fw-bold">Pembelian Berhasil!</h5>
                    <p class="text-muted">No. Faktur: <span class="font-monospace fw-bold text-primary" x-text="successKode"></span></p>
                </div>
                <div class="modal-footer d-flex flex-column gap-2">
                    <a :href="'/pembelian/' + successKode" class="btn btn-primary w-100">
                        <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                    </a>
                    <button @click="transaksiBaru()" class="btn btn-outline-secondary w-100">
                        Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script-bottom')
<script>
    function pembelianScreen() {
        return {
            cart: [],
            barcodeSearch: '',
            searchResults: [],
            showAutocomplete: false,

            tanggal: '{{ now()->format('Y-m-d\TH:i') }}',
            noFaktur: 'PM-{{ now()->format('YmdHis') }}{{ rand(100, 999) }}',
            kodeKas: '{{ $kasList->first()->kode ?? '' }}',

            supplierSearch: '',
            supplierResults: [],
            showSupplierDropdown: false,
            selectedSupplier: null,

            jenisPembayaran: 'tunai',
            bayar: 0,
            kembali: 0,
            jatuhTempo: '{{ now()->addDays(14)->format('Y-m-d') }}',

            diskonGlobal: 0,
            total: 0,
            grandTotal: 0,

            loading: false,
            flashMessage: '',
            flashType: 'success',
            showSuccessModal: false,
            successKode: '',

            init() {
                this.$watch('barcodeSearch', (val) => {
                    if (val.length >= 1) {
                        this.searchProduct(val);
                    } else {
                        this.showAutocomplete = false;
                        this.searchResults = [];
                    }
                });
                this.$watch('cart', () => this.recalcAll(), { deep: true });
                this.$watch('jenisPembayaran', () => this.hitungKembali());
                this.$nextTick(() => {
                    this.$refs.barcodeInput.focus();
                });
            },

            async searchProduct(query) {
                if (query.length < 1) return;
                try {
                    const res = await fetch(`/pembelian/ajax/product/${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.searchResults = [data.data];
                    } else {
                        this.searchResults = [];
                    }
                    this.showAutocomplete = true;
                } catch (e) {
                    this.searchResults = [];
                    this.showAutocomplete = true;
                }
            },

            async addByBarcode() {
                const kode = this.barcodeSearch.trim();
                if (!kode) return;
                try {
                    const res = await fetch(`/pembelian/ajax/product/${encodeURIComponent(kode)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.addToCart(data.data);
                        this.barcodeSearch = '';
                        this.showAutocomplete = false;
                        this.$nextTick(() => this.$refs.barcodeInput.focus());
                    } else {
                        this.showFlash('Produk tidak ditemukan', 'error');
                    }
                } catch (e) {
                    this.showFlash('Gagal mencari produk', 'error');
                }
            },

            onBarcodeKeydown(e) {
                if (e.key === 'Escape') {
                    this.showAutocomplete = false;
                }
            },

            addToCart(product) {
                const existing = this.cart.findIndex(item => item.kode_barang === product.kode);
                if (existing >= 0) {
                    this.cart[existing].qty += 1;
                    this.recalcItem(existing);
                } else {
                    this.cart.push({
                        kode_barang: product.kode,
                        nama_barang: product.nama,
                        harga: product.hpp || product.harga_toko || 0,
                        qty: 1,
                        diskon: 0,
                        satuan: product.satuan || 'PCS',
                        subtotal: product.hpp || product.harga_toko || 0,
                    });
                }
                this.recalcAll();
            },

            recalcItem(index) {
                const item = this.cart[index];
                if (!item) return;
                item.harga = Number(item.harga) || 0;
                item.qty = Math.max(1, Number(item.qty) || 1);
                item.diskon = Number(item.diskon) || 0;
                item.subtotal = (item.qty * item.harga) - item.diskon;
                if (item.subtotal < 0) item.subtotal = 0;
            },

            recalcAll() {
                this.total = this.cart.reduce((sum, item) => {
                    this.recalcItem(this.cart.indexOf(item));
                    return sum + (item.subtotal || 0);
                }, 0);
                this.diskonGlobal = Number(this.diskonGlobal) || 0;
                this.grandTotal = Math.max(0, this.total - this.diskonGlobal);
                this.hitungKembali();
            },

            hitungKembali() {
                this.bayar = Number(this.bayar) || 0;
                this.kembali = this.bayar - this.grandTotal;
            },

            async searchSupplier() {
                if (this.supplierSearch.length < 1) {
                    this.supplierResults = [];
                    this.showSupplierDropdown = false;
                    return;
                }
                try {
                    const res = await fetch(`/pembelian/ajax/supplier/${encodeURIComponent(this.supplierSearch)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.supplierResults = data.data;
                        this.showSupplierDropdown = true;
                    }
                } catch (e) {
                    this.supplierResults = [];
                }
            },

            selectSupplier(sup) {
                this.selectedSupplier = sup;
                this.supplierSearch = sup.nama;
                this.showSupplierDropdown = false;
            },

            async prosesTransaksi() {
                if (this.cart.length === 0) {
                    this.showFlash('Keranjang masih kosong', 'error');
                    return;
                }
                if (!this.selectedSupplier) {
                    this.showFlash('Pilih supplier terlebih dahulu', 'error');
                    return;
                }
                if (this.jenisPembayaran === 'tunai' && !this.kodeKas) {
                    this.showFlash('Pilih kas / akun terlebih dahulu', 'error');
                    return;
                }
                if (this.jenisPembayaran === 'tunai' && this.bayar < this.grandTotal) {
                    this.showFlash('Pembayaran kurang', 'error');
                    return;
                }

                this.loading = true;
                try {
                    const payload = {
                        items: this.cart.map(item => ({
                            kode_barang: item.kode_barang,
                            nama_barang: item.nama_barang,
                            qty: item.qty,
                            harga: item.harga,
                            diskon: item.diskon,
                            satuan: item.satuan,
                        })),
                        supplier: this.selectedSupplier ? this.selectedSupplier.kode : null,
                        kode_kas: this.kodeKas,
                        tanggal: this.tanggal,
                        jenis: this.jenisPembayaran,
                        diskon: this.diskonGlobal,
                        bayar: this.bayar,
                        jt: this.jatuhTempo,
                    };

                    const res = await fetch('{{ route("pembelian.store") }}', {
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
                        this.successKode = data.kode;
                        this.showSuccessModal = true;
                    } else {
                        this.showFlash(data.message || 'Gagal menyimpan transaksi', 'error');
                    }
                } catch (e) {
                    this.showFlash('Gagal menyimpan transaksi', 'error');
                } finally {
                    this.loading = false;
                }
            },

            batalTransaksi() {
                if (this.cart.length > 0 && !confirm('Batalkan transaksi? Keranjang akan dikosongkan.')) return;
                this.cart = [];
                this.bayar = 0;
                this.kembali = 0;
                this.diskonGlobal = 0;
                this.selectedSupplier = null;
                this.supplierSearch = '';
                this.barcodeSearch = '';
                this.flashMessage = '';
                this.$nextTick(() => this.$refs.barcodeInput.focus());
            },

            transaksiBaru() {
                this.showSuccessModal = false;
                this.cart = [];
                this.bayar = 0;
                this.kembali = 0;
                this.diskonGlobal = 0;
                this.selectedSupplier = null;
                this.supplierSearch = '';
                this.barcodeSearch = '';
                this.flashMessage = '';
                this.noFaktur = 'PM-' + new Date().toISOString().replace(/[-:T.]/g, '').slice(0, 14) + String(Math.floor(Math.random() * 900) + 100);
                this.$nextTick(() => this.$refs.barcodeInput.focus());
            },

            formatRupiah(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
            },

            showFlash(msg, type) {
                this.flashMessage = msg;
                this.flashType = type;
                setTimeout(() => this.flashMessage = '', 4000);
            },
        }
    }
</script>
@endsection