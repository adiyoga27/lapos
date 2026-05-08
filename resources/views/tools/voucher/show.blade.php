@extends('layouts.master')

@section('title', 'Detail Voucher')

@section('content')
<div class="d-flex align-items-center mb-3">
    <a href="{{ route('voucher.index') }}" class="me-3 text-muted"><i class="fa-solid fa-arrow-left"></i></a>
    <h4 class="mb-0">Detail Voucher</h4>
</div>

<div class="card">
    @php
        $now = now();
        $start = $voucher->tanggal_mulai ? \Carbon\Carbon::parse($voucher->tanggal_mulai) : null;
        $end = $voucher->tanggal_expired ? \Carbon\Carbon::parse($voucher->tanggal_expired) : null;
        if ($end && $now->gt($end)) {
            $status = 'expired';
        } elseif ($start && $now->lt($start)) {
            $status = 'upcoming';
        } else {
            $status = 'active';
        }
    @endphp
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted">Kode</small>
                <p class="fw-semibold"><code>{{ $voucher->kode }}</code></p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Status</small>
                <p>
                    @if($status === 'active')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($status === 'expired')
                        <span class="badge bg-danger">Expired</span>
                    @else
                        <span class="badge bg-warning text-dark">Upcoming</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Nama</small>
                <p class="fw-semibold">{{ $voucher->nama ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Tipe</small>
                <p class="fw-semibold">{{ $voucher->tipe ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Nilai</small>
                <p class="fw-semibold text-primary">
                    @if(($voucher->tipe ?? '') === 'persen')
                        {{ number_format($voucher->saldo ?? 0, 0) }}%
                    @else
                        Rp {{ number_format($voucher->saldo ?? 0, 0, ',', '.') }}
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Tanggal Mulai</small>
                <p class="fw-semibold">{{ $start ? $start->format('d/m/Y') : '-' }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Tanggal Akhir</small>
                <p class="fw-semibold">{{ $end ? $end->format('d/m/Y') : '-' }}</p>
            </div>
            @if($voucher->keterangan ?? false)
            <div class="col-12">
                <small class="text-muted">Keterangan</small>
                <p>{{ $voucher->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('voucher.index') }}" class="btn btn-secondary me-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('voucher.edit', $voucher->kode) }}" class="btn btn-warning">
            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
        </a>
    </div>
</div>
@endsection