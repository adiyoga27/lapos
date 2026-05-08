@extends('layouts.master')

@section('title', 'Detail Absensi')

@section('content')
<div class="d-flex align-items-center mb-3">
    <a href="{{ route('absensi.index') }}" class="me-3 text-muted"><i class="fa-solid fa-arrow-left"></i></a>
    <h4 class="mb-0">Detail Absensi</h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted">Kode Karyawan</small>
                <p class="fw-semibold">{{ $absensi->kode }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Nama</small>
                <p class="fw-semibold">{{ $absensi->nama }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Tanggal</small>
                <p class="fw-semibold">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Jam Masuk</small>
                <p class="fw-semibold">{{ $absensi->masuk ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Jam Pulang</small>
                <p class="fw-semibold">{{ $absensi->pulang ?? '-' }}</p>
            </div>
            @if($absensi->keterangan)
            <div class="col-12">
                <small class="text-muted">Keterangan</small>
                <p>{{ $absensi->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary me-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
        @if(!$absensi->pulang)
        <a href="{{ route('absensi.edit', $absensi->id) }}" class="btn btn-warning">
            <i class="fa-solid fa-right-from-bracket me-1"></i> Absen Pulang
        </a>
        @endif
    </div>
</div>
@endsection