@extends('layouts.master')
@section('title') Detail Pembelian @endsection
@section('content')
<div class="container" style="max-width:880px;">
    <div class="card mb-3">
        <div class="card-body">
            <div class="text-center border-bottom pb-3 mb-3">
                <h5 class="fw-bold mb-0">{{ config('app.name', 'Retail Pro') }}</h5>
            </div>
            <div class="text-center mb-3">
                <h5 class="fw-bold">FAKTUR PEMBELIAN</h5>
                <p class="font-monospace fw-bold text-primary mb-0">{{ $pembelian->kode }}</p>
            </div>
            <div class="row" style="font-size:0.875rem;">
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Tanggal</span>
                        <span>: {{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Supplier</span>
                        <span>: {{ $pembelian->supplierRef->nama ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Operator</span>
                        <span>: {{ $pembelian->operator }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Status</span>
                        <span>:
                            @if ($pembelian->lunas)
                                <span class="badge bg-success-subtle text-success">Tunai / Lunas</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Kredit</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0">Item Pembelian</h6>
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
                    @forelse ($pembelian->itemPembelian as $index => $item)
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
                    <span class="text-muted">Total</span>
                    <span class="fw-medium">Rp {{ number_format($pembelian->jumlah + ($pembelian->diskon ?? 0), 0, ',', '.') }}</span>
                </div>
                @if ($pembelian->diskon > 0)
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Diskon</span>
                    <span class="text-danger fw-medium">- Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold">
                    <span>Grand Total</span>
                    <span class="text-primary">Rp {{ number_format($pembelian->jumlah, 0, ',', '.') }}</span>
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
                            @if ($pembelian->lunas)
                                <span class="badge bg-success-subtle text-success">Tunai</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Kredit</span>
                            @endif
                        </span>
                    </div>
                </div>
                @if (!$pembelian->lunas)
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Jatuh Tempo</span>
                        <span>: {{ $pembelian->jt ? \Carbon\Carbon::parse($pembelian->jt)->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Sisa Hutang</span>
                        <span class="text-danger fw-medium">: Rp {{ number_format($pembelian->hutang ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
                @if ($pembelian->keterangan)
                <div class="col-12">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Keterangan</span>
                        <span>: {{ $pembelian->keterangan }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection