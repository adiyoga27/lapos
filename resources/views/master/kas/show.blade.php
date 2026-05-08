@extends('layouts.master')

@section('title') Detail Kas @endsection

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
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 no-print">
                <div>
                    <h4 class="card-title mb-0">Detail Kas</h4>
                    <small class="text-muted">{{ $item->kode }}</small>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Cetak</button>
                    <a href="{{ route('kas.edit', $item->kode) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a>
                    <a href="{{ route('kas.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-4 pb-3 border-bottom">
                    <div class="col-md-8">
                        <h3 class="fw-bold mb-1">{{ $item->nama }}</h3>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-dark"><i class="fa-solid fa-hashtag me-1"></i>{{ $item->kode }}</span>
                            @if($item->jenis ?? null)<span class="badge bg-secondary">{{ $item->jenis }}</span>@endif
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <div class="detail-label">Saldo</div>
                        <div class="fs-4 fw-bold {{ ($item->saldo ?? 0) < 0 ? 'text-danger' : 'text-success' }}">Rp {{ number_format($item->saldo ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-circle-info me-1"></i> Informasi Kas</span></div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Kode Kas</div>
                        <div class="detail-value">{{ $item->kode }}</div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Nama Kas</div>
                        <div class="detail-value">{{ $item->nama ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Jenis</div>
                        <div class="detail-value">{{ $item->jenis ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Saldo</div>
                        <div class="detail-value {{ ($item->saldo ?? 0) < 0 ? 'text-danger' : '' }}">Rp {{ number_format($item->saldo ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection