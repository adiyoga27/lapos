@extends('layouts.master')
@section('title') Edit Satuan @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Satuan</h4></div>
<div class="card-body">
<form action="{{ route('satuan.update', $item->nama) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3"><div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Nama Satuan</label>
<input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama satuan">
@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div></div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('satuan.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection