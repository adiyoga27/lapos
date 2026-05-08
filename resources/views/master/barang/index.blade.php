@extends('layouts.master')

@section('title') Data Barang @endsection

@section('css')
<style>
.badge-stok-normal { background-color: #198754; color: #fff; font-size: 0.85rem; padding: 6px 14px; font-weight: 600; }
.badge-stok-low { background-color: #dc3545; color: #fff; font-size: 0.85rem; padding: 6px 14px; font-weight: 600; }
.badge-stok-excess { background-color: #0d6efd; color: #fff; font-size: 0.85rem; padding: 6px 14px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Barang</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Barang
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table id="dataTable" class="table table-striped table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Sub Kategori</th>
                            <th>Harga Beli (HPP)</th>
                            <th>Harga Beli Terakhir</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Satuan Beli</th>
                            <th>Isi</th>
                            <th>Lokasi</th>
                            <th>Supplier</th>
                            <th>Tgl Beli</th>
                            <th>Kode Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        @php
                            $stok = $item->toko ?? 0;
                            $stokmin = $item->stokmin ?? 0;
                            $stokmax = $item->stokmax ?? 0;
                            if ($stokmin > 0 && $stok <= $stokmin) {
                                $stokClass = 'badge-stok-low';
                                $stokLabel = 'Kurang';
                            } elseif ($stokmax > 0 && $stok > $stokmax) {
                                $stokClass = 'badge-stok-excess';
                                $stokLabel = 'Berlebih';
                            } else {
                                $stokClass = 'badge-stok-normal';
                                $stokLabel = 'Normal';
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('barang.show', $item->kode) }}"><i class="fa-solid fa-eye me-2"></i>Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('barang.edit', $item->kode) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('barang.destroy', $item->kode) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategoriRef->nama ?? $item->kategori ?? '-' }}</td>
                            <td>{{ trim(($item->golongan1Ref->nama ?? $item->subgolongan1 ?? '') . ' ' . ($item->golongan2Ref->nama ?? $item->subgolongan2 ?? '')) ?: '-' }}</td>
                            <td class="text-end">Rp {{ number_format($item->hpp ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga_terakhir ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga_toko ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $stokClass }}">
                                    {{ number_format($stok, 0, ',', '.') }} {{ $item->satuan ?? '' }} — {{ $stokLabel }}
                                </span>
                            </td>
                            <td>{{ $item->satuanbeli ?? '-' }}</td>
                            <td>{{ $item->isi ?? '-' }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td>{{ $item->supplierRef->nama ?? $item->supplier ?? '-' }}</td>
                            <td>{{ $item->tgl_terakhir ? \Carbon\Carbon::parse($item->tgl_terakhir)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->kode_barcode ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
                    <span class="fw-semibold text-muted me-2" style="font-size:0.85rem;">Keterangan Stok:</span>
                    <span class="badge badge-stok-normal">Normal</span>
                    <span class="badge badge-stok-low">Kekurangan</span>
                    <span class="badge badge-stok-excess">Berlebih</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        responsive: true,
        dom: "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-solid fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] },
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa-solid fa-file-csv me-1"></i> CSV',
                className: 'btn btn-info btn-sm',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] }
            },
            {
                extend: 'print',
                text: '<i class="fa-solid fa-print me-1"></i> Cetak',
                className: 'btn btn-secondary btn-sm',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] }
            },
            {
                extend: 'colvis',
                text: '<i class="fa-solid fa-table-columns me-1"></i> Kolom',
                className: 'btn btn-outline-secondary btn-sm'
            }
        ],
        language: {
            search: "Cari:", lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "Sebelumnya", next: "Selanjutnya" },
            zeroRecords: "Data tidak ditemukan", emptyTable: "Tidak ada data"
        },
        columnDefs: [
            { orderable: false, targets: [0] },
            { className: 'no-wrap', targets: [0] }
        ]
    });
});
</script>
@endsection