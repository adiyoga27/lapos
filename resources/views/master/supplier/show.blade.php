@extends('layouts.master')

@section('title') Detail Supplier @endsection

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
                    <h4 class="card-title mb-0">Detail Supplier</h4>
                    <small class="text-muted">{{ $item->kode }}</small>
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Cetak</button>
                    <a href="{{ route('supplier.edit', $item->kode) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</a>
                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-4 pb-3 border-bottom">
                    <div class="col-md-8">
                        <h3 class="fw-bold mb-1">{{ $item->nama }}</h3>
                        <span class="badge bg-dark"><i class="fa-solid fa-hashtag me-1"></i>{{ $item->kode }}</span>
                    </div>
                    @if(($item->saldo_piutang ?? 0) != 0)
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <div class="detail-label">Saldo Hutang</div>
                        <div class="fs-5 fw-bold {{ ($item->saldo_piutang ?? 0) > 0 ? 'text-danger' : 'text-success' }}">Rp {{ number_format($item->saldo_piutang ?? 0, 0, ',', '.') }}</div>
                    </div>
                    @endif
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-user me-1"></i> Informasi Utama</span></div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Kode Supplier</div>
                        <div class="detail-value">{{ $item->kode }}</div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Nama Supplier</div>
                        <div class="detail-value">{{ $item->nama }}</div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="detail-label">Contact Person</div>
                        <div class="detail-value">{{ $item->contact ?? '-' }}</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-map-marker-alt me-1"></i> Alamat & Kontak</span></div>
                    <div class="col-12 col-md-6">
                        <div class="detail-label">Alamat</div>
                        <div class="detail-value">{{ $item->alamat ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Telepon</div>
                        <div class="detail-value">{{ $item->telp ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Kota</div>
                        <div class="detail-value">{{ $item->kotaRef->nama ?? $item->kota ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">NPWP</div>
                        <div class="detail-value">{{ $item->npwp ?? '-' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">No. Rekening</div>
                        <div class="detail-value">{{ $item->no_rekening ?? '-' }}</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12"><span class="section-title text-primary"><i class="fa-solid fa-money-bill me-1"></i> Keuangan</span></div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Batas Hutang</div>
                        <div class="detail-value">Rp {{ number_format($item->batas_hutang ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="detail-label">Saldo Hutang</div>
                        <div class="detail-value {{ ($item->saldo_hutang ?? 0) > 0 ? 'text-danger' : '' }}">Rp {{ number_format($item->saldo_hutang ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection