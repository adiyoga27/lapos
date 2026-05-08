@extends('layouts.master')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="container" style="max-width:720px;">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="text-muted small">Kode</span>
                    <p class="fw-semibold mb-0">{{ $pengeluaran->kode }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Tanggal</span>
                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d/m/Y') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Kategori Biaya</span>
                    <p class="fw-semibold mb-0">{{ $pengeluaran->biaya->nama ?? '-' }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Jumlah</span>
                    <p class="fw-semibold mb-0 text-danger">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Dari Kas</span>
                    <p class="fw-semibold mb-0">{{ $pengeluaran->kas->nama ?? '-' }}</p>
                </div>
                @if($pengeluaran->keterangan)
                <div class="col-sm-12">
                    <span class="text-muted small">Keterangan</span>
                    <p class="mb-0">{{ $pengeluaran->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
            <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square me-1"></i> Edit</a>
        </div>
    </div>
</div>
@endsection