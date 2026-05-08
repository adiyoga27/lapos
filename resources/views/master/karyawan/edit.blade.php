@extends('layouts.master')
@section('title') Edit Karyawan @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Karyawan</h4></div>
<div class="card-body">
<form action="{{ route('karyawan.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Karyawan</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Karyawan</label>
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
<label class="form-label"><i class="fa-solid fa-layer-group me-1"></i>Level</label>
<select name="level" class="form-select @error('level') is-invalid @enderror">
<option value="">Pilih Level</option>
@foreach($level as $lvl)
<option value="{{ $lvl->kode }}" {{ old('level', $item->level) == $lvl->kode ? 'selected' : '' }}>{{ $lvl->nama }}</option>
@endforeach
</select>
@error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-briefcase me-1"></i>Jabatan</label>
<input type="text" name="jabatan" value="{{ old('jabatan', $item->jabatan) }}" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Masukkan jabatan">
@error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-money-bill me-1"></i>Gaji</label>
<input type="number" name="gaji" value="{{ old('gaji', $item->gaji) }}" step="0.01" class="form-control @error('gaji') is-invalid @enderror" placeholder="Masukkan gaji">
@error('gaji')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3"><div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-calendar me-1"></i>Tanggal Masuk</label>
<input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $item->tanggal_masuk) }}" class="form-control @error('tanggal_masuk') is-invalid @enderror">
@error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div></div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('karyawan.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection