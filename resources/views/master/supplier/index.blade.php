@extends('layouts.master')
@section('title') Data Supplier @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
<h4 class="card-title mb-0">Data Supplier</h4>
<a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
</div>
<div class="card-body">
@if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="table-responsive"><table id="dataTable" class="table table-striped table-hover table-sm"><thead><tr>
<th>Aksi</th>
<th>Kode</th>
<th>Nama</th>
<th>Alamat</th>
<th>Telp</th>
<th>Kota</th>
<th class="text-end">Saldo Hutang</th>
</tr></thead><tbody>
@foreach($data as $item)<tr><td>
<div class="dropdown">
<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="{{ route('supplier.show', $item->kode) }}"><i class="fa-solid fa-eye me-2"></i>Detail</a></li>
<li><a class="dropdown-item" href="{{ route('supplier.edit', $item->kode) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a></li>
<li><hr class="dropdown-divider"></hr></li>
<li><form action="{{ route('supplier.destroy', $item->kode) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">@csrf @method('DELETE')<button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button></form></li>
</ul></div>
</td><td>{{ $item->kode }}</td><td>{{ $item->nama }}</td><td>{{ $item->alamat ?? '-' }}</td><td>{{ $item->telp ?? '-' }}</td><td>{{ $item->kota ?? '-' }}</td><td class="text-end fw-semibold {{ ($item->saldo_hutang ?? 0) > 0 ? 'text-danger' : '' }}">Rp {{ number_format($item->saldo_hutang ?? 0, 0, ',', '.') }}</td></tr>@endforeach
</tbody></table></div></div></div></div></div>
@endsection
@section('script')
<script>$(document).ready(function(){ $('#dataTable').DataTable({ responsive:true, columnDefs:[{orderable:false,targets:[0]}], language:{search:"Cari:",lengthMenu:"Tampilkan _MENU_ data",info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",paginate:{previous:"Sebelumnya",next:"Selanjutnya"},zeroRecords:"Data tidak ditemukan",emptyTable:"Tidak ada data"}}); });</script>
@endsection