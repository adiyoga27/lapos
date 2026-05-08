@extends('layouts.master')

@section('title', 'Piutang')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Piutang</h5>
        <a href="{{ route('piutang.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Terima Pembayaran</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($piutang as $item)
                    <tr>
                        <td>
                            <a href="{{ route('piutang.show', $item->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            @if($item->status !== 'Lunas')
                            <a href="{{ route('piutang.create') }}?id={{ $item->id }}" class="btn btn-sm btn-outline-success" title="Terima Pembayaran"><i class="fa-solid fa-money-bill-wave"></i></a>
                            @endif
                        </td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->sisa, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status === 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data piutang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        language: {
            search: "Cari:", lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "Sebelumnya", next: "Selanjutnya" },
            zeroRecords: "Data tidak ditemukan", emptyTable: "Tidak ada data"
        }
    });
});
</script>
@endsection