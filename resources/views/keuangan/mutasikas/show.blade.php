@extends('layouts.master')

@section('title', 'Detail Mutasi Kas')

@section('content')
<div class="container" style="max-width:720px;">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="text-muted small">Kode</span>
                    <p class="fw-semibold mb-0">{{ $mutasikas->kode }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Tanggal</span>
                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($mutasikas->tanggal)->format('d/m/Y') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Dari Kas</span>
                    <p class="fw-semibold mb-0">{{ $mutasikas->kasDari->nama ?? '-' }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Ke Kas</span>
                    <p class="fw-semibold mb-0">{{ $mutasikas->kasKe->nama ?? '-' }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Jumlah</span>
                    <p class="fw-semibold mb-0 text-primary">Rp {{ number_format($mutasikas->jumlah, 0, ',', '.') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Operator</span>
                    <p class="fw-semibold mb-0">{{ $mutasikas->operator ?? '-' }}</p>
                </div>
                @if($mutasikas->keterangan)
                <div class="col-sm-12">
                    <span class="text-muted small">Keterangan</span>
                    <p class="mb-0">{{ $mutasikas->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('mutasikas.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
            <a href="{{ route('mutasikas.edit', $mutasikas->kode) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square me-1"></i> Edit</a>
        </div>
    </div>
</div>
@endsection