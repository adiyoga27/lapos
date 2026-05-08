@extends('layouts.master')
@section('title') Edit Supplier @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Supplier</h4></div>
<div class="card-body">
<form action="{{ route('supplier.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Supplier</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Supplier</label>
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
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-city me-1"></i>Kota</label>
<input type="text" name="kota" value="{{ old('kota', $item->kota) }}" class="form-control @error('kota') is-invalid @enderror" placeholder="Masukkan kota">
@error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-file-invoice me-1"></i>NPWP</label>
<input type="text" name="npwp" value="{{ old('npwp', $item->npwp) }}" class="form-control @error('npwp') is-invalid @enderror" placeholder="Masukkan NPWP">
@error('npwp')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-user-tie me-1"></i>Contact Person</label>
<input type="text" name="contact" value="{{ old('contact', $item->contact) }}" class="form-control @error('contact') is-invalid @enderror" placeholder="Nama contact person">
@error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-credit-card me-1"></i>No. Rekening</label>
<input type="text" name="no_rekening" value="{{ old('no_rekening', $item->no_rekening) }}" class="form-control @error('no_rekening') is-invalid @enderror" placeholder="Nomor rekening">
@error('no_rekening')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-money-check me-1"></i>Batas Hutang</label>
<input type="number" name="batas_hutang" value="{{ old('batas_hutang', $item->batas_hutang) }}" step="0.01" class="form-control @error('batas_hutang') is-invalid @enderror" placeholder="Batas hutang">
@error('batas_hutang')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection