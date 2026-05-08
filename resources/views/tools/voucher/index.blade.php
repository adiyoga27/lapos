@extends('layouts.master')

@section('title', 'Voucher')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Voucher</h4>
    <a href="{{ route('voucher.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Tambah Voucher
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped table-sm" width="100%">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voucher as $item)
                    @php
                        $now = now();
                        $start = $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai) : null;
                        $end = $item->tanggal_expired ? \Carbon\Carbon::parse($item->tanggal_expired) : null;
                        if ($end && $now->gt($end)) {
                            $status = 'expired';
                        } elseif ($start && $now->lt($start)) {
                            $status = 'upcoming';
                        } else {
                            $status = 'active';
                        }
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('voucher.show', $item->kode) }}" class="text-primary me-2" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('voucher.edit', $item->kode) }}" class="text-warning me-2" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td><code>{{ $item->kode }}</code></td>
                        <td>{{ $item->nama ?? '-' }}</td>
                        <td>{{ $item->tipe ?? '-' }}</td>
                        <td class="text-end">
                            @if(($item->tipe ?? '') === 'persen')
                                {{ number_format($item->saldo ?? 0, 0) }}%
                            @else
                                Rp {{ number_format($item->saldo ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>{{ $start ? $start->format('d/m/Y') : '-' }}</td>
                        <td>{{ $end ? $end->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($status === 'expired')
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fa-solid fa-ticket fa-2x mb-2 d-block"></i>
                            Tidak ada data voucher
                        </td>
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