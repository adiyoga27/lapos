@extends('layouts.master')

@section('title', 'Mutasi Kas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Mutasi Kas</h5>
        <a href="{{ route('mutasikas.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Mutasi Kas</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Dari Kas</th>
                        <th>Ke Kas</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasikas as $item)
                    <tr>
                        <td>
                            <a href="{{ route('mutasikas.show', $item->kode) }}" class="btn btn-sm btn-outline-primary me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('mutasikas.edit', $item->kode) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td><code>{{ $item->kode }}</code></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->kasDari->nama ?? '-' }}</td>
                        <td>{{ $item->kasKe->nama ?? '-' }}</td>
                        <td class="text-end text-primary fw-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data mutasi kas</td>
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