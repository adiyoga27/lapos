@extends('layouts.master')
@section('title') Edit Kota @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Kota</h4>
                <a href="{{ route('kota.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('kota.update', $item->kode) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-city me-1"></i>Kode Kota</label>
                            <input type="text" name="kode" value="{{ old('kode', $item->kode) }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode" required>
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Kota</label>
                            <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('kota.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection