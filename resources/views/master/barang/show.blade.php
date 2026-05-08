@extends('layouts.master')

@section('title') Detail Barang @endsection

@section('css')
<style>
    @media print {
        .no-print { display: none !important; }
        #sidebar, .topbar, footer { display: none !important; }
        #content { margin-left: 0 !important; }
        .card { border: 1px solid #dee2e6 !important; }
    }
    .detail-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6c757d; margin-bottom: 0.15rem; }
    .detail-value { font-size: 0.95rem; font-weight: 600; }
    .section-title { font-size: 0.95rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    .badge-stok-normal { background-color: #198754; color: #fff; font-size: 0.8rem; padding: 5px 12px; font-weight: 600; }
    .badge-stok-low { background-color: #dc3545; color: #fff; font-size: 0.8rem; padding: 5px 12px; font-weight: 600; }
    .badge-stok-excess { background-color: #0d6efd; color: #fff; font-size: 0.8rem; padding: 5px 12px; font-weight: 600; }
    .price-tag { font-size: 1rem; font-weight: 700; }
    .price-buy { color: #dc3545; }
    .price-sell { color: #198754; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 no-print">
                <div>
                    <h4 class="card-title mb-0">Detail Barang</h4>
                    <small class="text-muted">{{ $barang->kode }}</small>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Cetak</button>
                    <a href="{{ route('barang.edit', $barang->kode) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a>
                    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Kopf: Info Utama -->
                <div class="row align-items-center mb-4 pb-3 border-bottom">
                    <div class="col-md-8">
                        <h3 class="fw-bold mb-1">{{ $barang->nama }}</h3>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-dark"><i class="fa-solid fa-barcode me-1"></i>{{ $barang->kode }}</span>
                            @if($barang->kategoriRef ?? null)<span class="badge bg-secondary">{{ $barang->kategoriRef->nama }}</span>@endif
                            @if($barang->golongan1Ref->nama ?? $barang->subgolongan1 ?? null)<span class="badge bg-light text-dark">{{ $barang->golongan1Ref->nama ?? $barang->subgolongan1 }}</span>@endif
                            @if($barang->golongan2Ref->nama ?? $barang->subgolongan2 ?? null)<span class="badge bg-light text-dark">{{ $barang->golongan2Ref->nama ?? $barang->subgolongan2 }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        @php
                            $stok = $barang->toko ?? 0;
                            $stokmin = $barang->stokmin ?? 0;
                            $stokmax = $barang->stokmax ?? 0;
                            if ($stokmin > 0 && $stok <= $stokmin) {
                                $badgeClass = 'badge-stok-low';
                                $badgeText = 'Stok Kurang';
                            } elseif ($stokmax > 0 && $stok > $stokmax) {
                                $badgeClass = 'badge-stok-excess';
                                $badgeText = 'Stok Berlebih';
                            } else {
                                $badgeClass = 'badge-stok-normal';
                                $badgeText = 'Stok Normal';
                            }
                        @endphp
                        <div class="detail-label">Stok Toko</div>
                        <div class="fs-4 fw-bold">{{ number_format($stok, 0, ',', '.') }} {{ $barang->satuan ?? '' }}</div>
                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    </div>
                </div>

                <!-- Baris 1: Harga Utama -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-danger bg-opacity-10 border-0 h-100">
                            <div class="card-body py-2 px-3">
                                <div class="detail-label text-danger">HPP (Harga Beli)</div>
                                <div class="price-tag price-buy">Rp {{ number_format($barang->hpp ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger bg-opacity-10 border-0 h-100">
                            <div class="card-body py-2 px-3">
                                <div class="detail-label text-danger">Harga Beli Terakhir</div>
                                <div class="price-tag price-buy">Rp {{ number_format($barang->harga_terakhir ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success bg-opacity-10 border-0 h-100">
                            <div class="card-body py-2 px-3">
                                <div class="detail-label text-success">Harga Jual Toko</div>
                                <div class="price-tag price-sell">Rp {{ number_format($barang->harga_toko ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success bg-opacity-10 border-0 h-100">
                            <div class="card-body py-2 px-3">
                                <div class="detail-label text-success">Harga Partai</div>
                                <div class="price-tag price-sell">Rp {{ number_format($barang->harga_partai ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Stok & Lokasi -->
                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-cubes me-1"></i> Stok & Lokasi</span></div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Stok Gudang</div>
                        <div class="detail-value">{{ number_format($barang->gudang ?? 0, 0, ',', '.') }} {{ $barang->satuan ?? '' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Stok Minimum</div>
                        <div class="detail-value">{{ number_format($stokmin, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Stok Maksimum</div>
                        <div class="detail-value">{{ number_format($stokmax, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Lokasi</div>
                        <div class="detail-value">{{ $barang->lokasi ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Satuan Beli</div>
                        <div class="detail-value">{{ $barang->satuanbeli ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Satuan Jual</div>
                        <div class="detail-value">{{ $barang->satuan ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Isi</div>
                        <div class="detail-value">{{ number_format($barang->isi ?? 1, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Expired</div>
                        <div class="detail-value">{{ $barang->expired ? \Carbon\Carbon::parse($barang->expired)->format('d/m/Y') : '-' }}</div>
                    </div>
                    @if($barang->satuan2 ?? null)
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Satuan 2 / Isi</div>
                        <div class="detail-value">{{ $barang->satuan2 }} / {{ number_format($barang->isi2 ?? 1, 0, ',', '.') }}</div>
                    </div>
                    @endif
                    @if($barang->satuan3 ?? null)
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Satuan 3 / Isi</div>
                        <div class="detail-value">{{ $barang->satuan3 }} / {{ number_format($barang->isi3 ?? 1, 0, ',', '.') }}</div>
                    </div>
                    @endif
                </div>

                <!-- Section: Harga Lainnya -->
                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-tag me-1"></i> Harga Lainnya</span></div>
                    @if($barang->harga_toko2 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Toko 2</div><div class="detail-value">Rp {{ number_format($barang->harga_toko2, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_toko3 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Toko 3</div><div class="detail-value">Rp {{ number_format($barang->harga_toko3, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_partai2 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Partai 2</div><div class="detail-value">Rp {{ number_format($barang->harga_partai2, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_partai3 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Partai 3</div><div class="detail-value">Rp {{ number_format($barang->harga_partai3, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_cabang ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Cabang</div><div class="detail-value">Rp {{ number_format($barang->harga_cabang, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_cabang2 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Cabang 2</div><div class="detail-value">Rp {{ number_format($barang->harga_cabang2, 0, ',', '.') }}</div></div> @endif
                    @if($barang->harga_cabang3 ?? 0) <div class="col-6 col-md-3"><div class="detail-label">Harga Cabang 3</div><div class="detail-value">Rp {{ number_format($barang->harga_cabang3, 0, ',', '.') }}</div></div> @endif
                </div>

                <!-- Section: Margin & Diskon -->
                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-percent me-1"></i> Margin & Diskon</span></div>
                    <div class="col-6 col-md-3"><div class="detail-label">Diskon</div><div class="detail-value">{{ number_format($barang->diskon ?? 0, 2, ',', '.') }}%</div></div>
                    <div class="col-6 col-md-3"><div class="detail-label">Margin Toko</div><div class="detail-value">{{ number_format($barang->margin_toko ?? 0, 0, ',', '.') }}</div></div>
                    <div class="col-6 col-md-3"><div class="detail-label">Margin Partai</div><div class="detail-value">{{ number_format($barang->margin_partai ?? 0, 0, ',', '.') }}</div></div>
                    <div class="col-6 col-md-3"><div class="detail-label">Margin Cabang</div><div class="detail-value">{{ number_format($barang->margin_cabang ?? 0, 0, ',', '.') }}</div></div>
                </div>

                <!-- Section: Barcode & Supplier -->
                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-barcode me-1"></i> Barcode & Supplier</span></div>
                    @if($barang->kode_barcode ?? null)<div class="col-6 col-md-4"><div class="detail-label">Barcode</div><div class="detail-value"><code>{{ $barang->kode_barcode }}</code></div></div>@endif
                    @if($barang->kode_barcode2 ?? null)<div class="col-6 col-md-4"><div class="detail-label">Barcode 2</div><div class="detail-value"><code>{{ $barang->kode_barcode2 }}</code></div></div>@endif
                    @if($barang->kode_barcode3 ?? null)<div class="col-6 col-md-4"><div class="detail-label">Barcode 3</div><div class="detail-value"><code>{{ $barang->kode_barcode3 }}</code></div></div>@endif
                    <div class="col-6 col-md-4"><div class="detail-label">Supplier</div><div class="detail-value">{{ $barang->supplierRef->nama ?? $barang->supplier ?? '-' }}</div></div>
                    <div class="col-6 col-md-4"><div class="detail-label">Tgl Beli Terakhir</div><div class="detail-value">{{ $barang->tgl_terakhir ? \Carbon\Carbon::parse($barang->tgl_terakhir)->format('d/m/Y') : '-' }}</div></div>
                    <div class="col-6 col-md-4"><div class="detail-label">Pajak</div><div class="detail-value">{{ $barang->pajak ?? '-' }}</div></div>
                    @if($barang->ukuranRel->nama ?? $barang->ukuran ?? null)<div class="col-6 col-md-4"><div class="detail-label">Ukuran</div><div class="detail-value">{{ $barang->ukuranRel->nama ?? $barang->ukuran }}</div></div>@endif
                    @if($barang->warnaRel->nama ?? $barang->warna ?? null)<div class="col-6 col-md-4"><div class="detail-label">Warna</div><div class="detail-value">{{ $barang->warnaRel->nama ?? $barang->warna }}</div></div>@endif
                </div>

                @if($barang->ket ?? null)
                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-note-sticky me-1"></i> Keterangan</span></div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">{{ $barang->ket }}</div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection