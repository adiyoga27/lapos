@extends('layouts.master')
@section('title') Detail Return Penjualan @endsection
@section('content')
<div class="container" style="max-width:880px;">
    <div class="card mb-3">
        <div class="card-body">
            <div class="text-center border-bottom pb-3 mb-3">
                <h5 class="fw-bold mb-0">{{ config('app.name', 'Retail Pro') }}</h5>
            </div>
            <div class="text-center mb-3">
                <h5 class="fw-bold">RETURN PENJUALAN</h5>
                <p class="font-monospace fw-bold text-primary mb-0">{{ $return->kode }}</p>
            </div>
            <div class="row" style="font-size:0.875rem;">
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Tanggal</span>
                        <span>: {{ \Carbon\Carbon::parse($return->tanggal)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">No. Faktur</span>
                        <span>: {{ $return->no_faktur }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Nama Barang</span>
                        <span>: {{ $return->nama_barang }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Harga</span>
                        <span>: Rp {{ number_format($return->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Tgl Penjualan</span>
                        <span>: {{ $return->tgl_jual ? \Carbon\Carbon::parse($return->tgl_jual)->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Operator</span>
                        <span>: {{ $return->operator }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Kode Barang</span>
                        <span>: {{ $return->kode_barang }}</span>
                    </div>
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Diskon</span>
                        <span>: Rp {{ number_format($return->diskon, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Qty</span>
                        <span>: {{ number_format($return->qty, 0) }} {{ $return->satuan }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Jumlah</span>
                        <span class="text-danger fw-bold">: Rp {{ number_format($return->jumlah, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if ($return->alasan)
                <div class="col-12">
                    <div class="d-flex mb-1">
                        <span class="text-muted" style="width:130px; flex-shrink:0;">Alasan</span>
                        <span>: {{ $return->alasan }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('return_penjualan.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection