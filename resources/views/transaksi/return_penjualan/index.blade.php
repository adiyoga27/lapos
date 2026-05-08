@extends('layouts.master')

@section('title', 'Return Penjualan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Return Penjualan</h5>
        <a href="{{ route('return_penjualan.create') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i> Return Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>No Faktur</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $item)
                    <tr>
                        <td>
                            <a href="{{ route('return_penjualan.show', $item->kode) }}" class="btn btn-sm btn-outline-primary me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                            <form action="{{ route('return_penjualan.destroy', $item->kode) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus return penjualan {{ $item->kode }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                        <td><code>{{ $item->kode }}</code></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td><code>{{ $item->no_faktur }}</code></td>
                        <td>{{ $item->penjualan->nama_pelanggan ?? 'Umum' }}</td>
                        <td class="text-end">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada return penjualan</td>
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