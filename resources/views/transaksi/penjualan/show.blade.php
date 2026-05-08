@extends('layouts.master')
@section('title') Detail Penjualan @endsection
@section('content')
@php
    $perusahaan = \App\Models\SetupPerusahaan::first();
@endphp

<div class="container" style="max-width:880px;" id="printArea">
    <div class="card mb-3">
        <div class="card-body">
            <div class="text-center border-bottom pb-3 mb-3">
                @if ($perusahaan && $perusahaan->logo)
                    <img src="{{ asset('storage/' . $perusahaan->logo) }}" alt="Logo" class="mb-2" style="height:64px;">
                @endif
                <h5 class="fw-bold mb-0">{{ $perusahaan->nama ?? config('app.name', 'Retail Pro') }}</h5>
                @if ($perusahaan)
                    <p class="text-muted small mb-0">{{ $perusahaan->alamat }}</p>
                    <p class="text-muted small mb-0">Telp: {{ $perusahaan->telp }} | NPWP: {{ $perusahaan->npwp ?? '-' }}</p>
                @endif
            </div>

            <div class="text-center mb-3">
                <h5 class="fw-bold">FAKTUR PENJUALAN</h5>
                <p class="font-monospace fw-bold text-primary mb-0">{{ $penjualan->kode }}</p>
            </div>

            <div class="row" style="font-size:0.875rem;">
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Tanggal</span>
                        <span>: {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Pelanggan</span>
                        <span>: {{ $penjualan->nama_pelanggan ?: 'Umum' }}</span>
                    </div>
                    @if ($penjualan->alamat_pelanggan)
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Alamat</span>
                        <span>: {{ $penjualan->alamat_pelanggan }}</span>
                    </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Kasir</span>
                        <span>: {{ $penjualan->operator }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Kas / Akun</span>
                        <span>: {{ $penjualan->kas->nama ?? '-' }}</span>
                    </div>
                    @if ($penjualan->keterangan)
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Keterangan</span>
                        <span>: {{ $penjualan->keterangan }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0">Item Penjualan</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover small mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Qty</th>
                        <th>Satuan</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Diskon</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualan->itemPenjualan as $index => $item)
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td class="font-monospace small text-primary">{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td class="text-center">{{ number_format($item->qty, 0) }}</td>
                        <td class="text-muted">{{ $item->satuan }}</td>
                        <td class="text-end">{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-end text-danger">{{ number_format($item->diskon, 0, ',', '.') }}</td>
                        <td class="text-end fw-medium">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada item</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="ms-auto" style="max-width:250px;">
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-medium">{{ number_format($penjualan->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Diskon</span>
                    <span class="text-danger fw-medium">- {{ number_format($penjualan->diskon, 0, ',', '.') }}</span>
                </div>
                @if ($penjualan->tax > 0)
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Pajak ({{ $penjualan->tax }}%)</span>
                    <span class="fw-medium">{{ number_format($penjualan->tax_rupiah, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold">
                    <span>Grand Total</span>
                    <span class="text-primary">{{ number_format($penjualan->jumlah, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row" style="font-size:0.875rem;">
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Metode Bayar</span>
                        <span>:
                            @if ($penjualan->jenis === 'tunai')
                                <span class="badge bg-success-subtle text-success">Tunai</span>
                            @elseif ($penjualan->jenis === 'debit')
                                <span class="badge bg-primary-subtle text-primary">Debit</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Kredit</span>
                            @endif
                        </span>
                    </div>
                </div>
                @if ($penjualan->jenis === 'tunai' || $penjualan->jenis === 'debit')
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Bayar</span>
                        <span>: {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Kembali</span>
                        <span class="text-success fw-medium">: {{ number_format($penjualan->kembali, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
                @if ($penjualan->jenis === 'kredit')
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Jatuh Tempo</span>
                        <span>: {{ \Carbon\Carbon::parse($penjualan->jt)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Status</span>
                        <span>:
                            @if ($penjualan->lunas)
                                <span class="text-success fw-medium">Lunas</span>
                            @else
                                <span class="text-danger fw-medium">Belum Lunas</span>
                            @endif
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa-solid fa-print me-1"></i> Cetak Nota
        </button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
@section('script-bottom')
<style>
    @media print {
        .no-print { display: none !important; }
        #printArea { max-width: 100% !important; }
    }
</style>
@endsection