@extends('layouts.master')
@section('title') Edit Sales @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Sales</h4></div>
<div class="card-body">
<form action="{{ route('sales.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Sales</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Sales</label>
<input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama">
@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3"><div class="col-12">
<label class="form-label"><i class="fa-solid fa-map-marker-alt me-1"></i>Alamat</label>
<textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat">{{ old('alamat', $item->alamat) }}</textarea>
@error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div></div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-phone me-1"></i>Telepon</label>
<input type="text" name="telp" value="{{ old('telp', $item->telp) }}" class="form-control @error('telp') is-invalid @enderror" placeholder="Masukkan telepon">
@error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('sales.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection