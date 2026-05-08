@extends('layouts.master')

@section('title', 'Detail Pembayaran Hutang')

@section('content')
<div class="container" style="max-width:720px;">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="text-muted small">Kode</span>
                    <p class="fw-semibold mb-0">{{ $hutang->kode }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Tanggal</span>
                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($hutang->tanggal)->format('d/m/Y') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Supplier</span>
                    <p class="fw-semibold mb-0">{{ $hutang->supplier->nama ?? '-' }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Status</span>
                    <p class="mb-0">
                        @if ($hutang->status === 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Jumlah</span>
                    <p class="fw-semibold mb-0">Rp {{ number_format($hutang->jumlah, 0, ',', '.') }}</p>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted small">Sisa</span>
                    <p class="fw-semibold mb-0">Rp {{ number_format($hutang->sisa, 0, ',', '.') }}</p>
                </div>
                @if($hutang->kas)
                <div class="col-sm-6">
                    <span class="text-muted small">Dari Kas</span>
                    <p class="fw-semibold mb-0">{{ $hutang->kas->nama ?? '-' }}</p>
                </div>
                @endif
                @if($hutang->keterangan)
                <div class="col-sm-12">
                    <span class="text-muted small">Keterangan</span>
                    <p class="mb-0">{{ $hutang->keterangan }}</p>
                </div>
                @endif
            </div>

            @if(isset($pembayaran) && count($pembayaran) > 0)
            <div class="mt-4 pt-3 border-top">
                <h6 class="fw-semibold mb-3">Riwayat Pembayaran</h6>
                <table class="table table-sm small">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah</th>
                            <th>Kas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $bayar)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($bayar->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-end">Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</td>
                            <td class="text-muted">{{ $bayar->kas->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('hutang.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>
    </div>
</div>
@endsection