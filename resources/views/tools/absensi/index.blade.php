@extends('layouts.master')

@section('title', 'Absensi Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Absensi Karyawan</h4>
    <a href="{{ route('absensi.create') }}" class="btn btn-success btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Absen Masuk
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped table-sm" width="100%">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $item)
                    <tr>
                        <td>
                            <a href="{{ route('absensi.show', $item->id) }}" class="text-primary me-2" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if(!$item->pulang)
                            <a href="{{ route('absensi.edit', $item->id) }}" class="text-warning me-2" title="Absen Pulang">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td><code class="text-primary">{{ $item->kode }}</code></td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->masuk ?? '-' }}</td>
                        <td>{{ $item->pulang ?? '-' }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fa-solid fa-calendar-check fa-2x mb-2 d-block"></i>
                            Tidak ada data absensi
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