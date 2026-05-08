@extends('layouts.master')
@section('title') Edit Biaya @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Biaya</h4></div>
<div class="card-body">
<form action="{{ route('biaya.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-file-invoice-dollar me-1"></i>Kode Biaya</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Biaya</label>
<input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama">
@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('biaya.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection