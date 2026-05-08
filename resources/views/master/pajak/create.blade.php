@extends('layouts.master')
@section('title') Tambah Pajak @endsection
@section('content')
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h4 class="card-title mb-0"><i class="fa-solid fa-plus me-1"></i>Tambah Pajak</h4></div>
<div class="card-body">
<form action="{{ route('pajak.store') }}" method="POST">
@csrf
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-receipt me-1"></i>Kode Pajak</label>
<input type="text" name="kode" value="{{ old('kode') }}" required class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode">
@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
<label class="form-label"><i class="fa-solid fa-percent me-1"></i>Nilai (%)</label>
<input type="number" name="nilai" value="{{ old('nilai', 0) }}" step="0.01" required class="form-control @error('nilai') is-invalid @enderror" placeholder="Masukkan nilai">
@error('nilai')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="d-flex justify-content-end gap-2">
<a href="{{ route('pajak.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
<button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
</div>
</form></div></div></div></div>
@endsection