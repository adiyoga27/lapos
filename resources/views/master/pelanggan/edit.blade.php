@extends('layouts.master')
@section('title') Edit Pelanggan @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Pelanggan</h4></div>
<div class="card-body">
<form action="{{ route('pelanggan.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Pelanggan</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Pelanggan</label>
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
<label class="form-label"><i class="fa-solid fa-map-pin me-1"></i>Rayon</label>
<input type="text" name="rayon" value="{{ old('rayon', $item->rayon) }}" class="form-control @error('rayon') is-invalid @enderror" placeholder="Masukkan rayon">
@error('rayon')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-map-location-dot me-1"></i>Area</label>
<input type="text" name="area" value="{{ old('area', $item->area) }}" class="form-control @error('area') is-invalid @enderror" placeholder="Masukkan area">
@error('area')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-user-tie me-1"></i>Sales</label>
<select name="sales" class="form-select @error('sales') is-invalid @enderror">
<option value="">Pilih Sales</option>
@foreach($sales as $sls)
<option value="{{ $sls->kode }}" {{ old('sales', $item->sales) == $sls->kode ? 'selected' : '' }}>{{ $sls->nama }}</option>
@endforeach
</select>
@error('sales')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-object-group me-1"></i>Kode Group</label>
<input type="text" name="kode_group" value="{{ old('kode_group', $item->kode_group) }}" class="form-control @error('kode_group') is-invalid @enderror" placeholder="Masukkan kode group">
@error('kode_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3"><div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-filter me-1"></i>Jenis</label>
<input type="text" name="jenis" value="{{ old('jenis', $item->jenis) }}" class="form-control @error('jenis') is-invalid @enderror" placeholder="Masukkan jenis">
@error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div></div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('pelanggan.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection