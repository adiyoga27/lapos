@extends('layouts.master')
@section('title') Data Kas @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
<h4 class="card-title mb-0">Data Kas</h4>
<a href="{{ route('kas.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Tambah</a>
</div>
<div class="card-body">
@if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
<div class="table-responsive"><table id="dataTable" class="table table-striped table-hover table-sm"><thead><tr>
<th>Aksi</th>
<th>Kode</th>
<th>Nama</th>
<th class="text-end">Saldo</th>
<th>Jenis</th>
</tr></thead><tbody>
@foreach($data as $item)<tr><td>
<div class="dropdown">
<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="{{ route('kas.show', $item->kode) }}"><i class="fa-solid fa-eye me-2"></i>Detail</a></li>
<li><a class="dropdown-item" href="{{ route('kas.edit', $item->kode) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a></li>
<li><hr class="dropdown-divider"></hr></li>
<li><form action="{{ route('kas.destroy', $item->kode) }}" method="POST" onsubmit="return confirm('Hapus kas ini?')">@csrf @method('DELETE')<button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button></form></li>
</ul></div>
</td><td>{{ $item->kode }}</td><td>{{ $item->nama }}</td><td class="text-end fw-semibold {{ ($item->saldo ?? 0) < 0 ? 'text-danger' : '' }}">Rp {{ number_format($item->saldo ?? 0, 0, ',', '.') }}</td><td>
@if(($item->jenis ?? '') == 'Tunai')<span class="badge bg-success-subtle text-success">Tunai</span>
@elseif(($item->jenis ?? '') == 'Bank')<span class="badge bg-primary-subtle text-primary">Bank</span>
@elseif(($item->jenis ?? '') == 'Giro')<span class="badge bg-purple-subtle text-purple" style="background-color:#e8daef;color:#7d3c98;">Giro</span>
@else<span class="text-muted">-</span>@endif
</td></tr>@endforeach
</tbody></table></div></div></div></div></div>

@if(isset($bank) && count($bank) > 0)
<div class="row mt-3"><div class="col-12"><div class="card">
<div class="card-header"><h5 class="card-title mb-0">Daftar Bank</h5></div>
<div class="card-body">
<div class="table-responsive"><table class="table table-striped table-hover table-sm"><thead><tr>
<th>Kode</th>
<th>Beban</th>
<th>Aksi</th>
</tr></thead><tbody>
@foreach($bank as $bnk)<tr><td>{{ $bnk->kode }}</td><td>Rp {{ number_format($bnk->beban ?? 0, 0, ',', '.') }}</td><td>
<div class="dropdown">
<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>
<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="{{ route('bank.show', $bnk->kode) }}"><i class="fa-solid fa-eye me-2"></i>Detail</a></li>
<li><a class="dropdown-item" href="{{ route('bank.edit', $bnk->kode) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a></li>
</ul></div>
</td></tr>@endforeach
</tbody></table></div></div></div></div></div>
@endif
@endsection
@section('script')
<script>$(document).ready(function(){ $('#dataTable').DataTable({ responsive:true, columnDefs:[{orderable:false,targets:[0]}], language:{search:"Cari:",lengthMenu:"Tampilkan _MENU_ data",info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",paginate:{previous:"Sebelumnya",next:"Selanjutnya"},zeroRecords:"Data tidak ditemukan",emptyTable:"Tidak ada data"}}); });</script>
@endsection