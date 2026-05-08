@extends('layouts.master')
@section('title') Tambah Kategori @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-plus me-1"></i>Tambah Kategori</h4>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tag me-1"></i>Kode Kategori</label>
                            <input type="text" name="kode" value="{{ old('kode') }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode" required>
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-star me-1"></i>Point Member</label>
                            <input type="number" name="point_member" value="{{ old('point_member', 0) }}" class="form-control @error('point_member') is-invalid @enderror" placeholder="Point member">
                            @error('point_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection