@extends('layouts.master')

@section('title') Data Warna @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Warna</h4>
                <a href="{{ route('warna.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Warna
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Kode Warna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('warna.show', $item->kode) }}"><i class="fa-solid fa-eye me-2"></i>Detail</a></li>
                                            <li><a class="dropdown-item" href="{{ route('warna.edit', $item->kode) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('warna.destroy', $item->kode) }}" method="POST" onsubmit="return confirm('Hapus warna ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $item->kode }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        columnDefs: [{ orderable: false, targets: [0] }],
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