@extends('layouts.master')

@section('title', 'Pengeluaran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Pengeluaran</h5>
        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Pengeluaran</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Kategori Biaya</th>
                        <th>Jumlah</th>
                        <th>Kas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluaran as $item)
                    <tr>
                        <td>
                            <a href="{{ route('pengeluaran.show', $item->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('pengeluaran.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->biaya->nama ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->kas->nama ?? '-' }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data pengeluaran</td>
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