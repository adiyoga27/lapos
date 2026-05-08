@extends('layouts.master')
@section('title') Edit Kas @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Kas</h4></div>
<div class="card-body">
<form action="{{ route('kas.update', $item->kode) }}" method="POST">
@csrf @method('PUT')
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Kas</label>
<input type="text" name="kode" value="{{ old('kode', $item->kode) }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Kas</label>
<input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama">
@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-wallet me-1"></i>Saldo</label>
<input type="number" name="saldo" value="{{ old('saldo', $item->saldo) }}" step="0.01" class="form-control @error('saldo') is-invalid @enderror" placeholder="Saldo">
@error('saldo')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-filter me-1"></i>Jenis</label>
<select name="jenis" required class="form-select @error('jenis') is-invalid @enderror">
<option value="">Pilih Jenis</option>
<option value="Tunai" {{ old('jenis', $item->jenis) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
<option value="Bank" {{ old('jenis', $item->jenis) == 'Bank' ? 'selected' : '' }}>Bank</option>
<option value="Giro" {{ old('jenis', $item->jenis) == 'Giro' ? 'selected' : '' }}>Giro</option>
</select>
@error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('kas.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
</div>
</form></div></div></div></div>
@endsection