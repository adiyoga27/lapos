@extends('layouts.master')
@section('title') Tambah Member @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-plus me-1"></i>Tambah Member</h4>
                <a href="{{ route('member.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('member.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-id-card me-1"></i>ID Kartu</label>
                            <input type="text" name="id_kartu" value="{{ old('id_kartu') }}" class="form-control @error('id_kartu') is-invalid @enderror" placeholder="Masukkan ID kartu" required>
                            @error('id_kartu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Member</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fa-solid fa-map-marker-alt me-1"></i>Alamat</label>
                            <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-phone me-1"></i>Telepon</label>
                            <input type="text" name="telp" value="{{ old('telp') }}" class="form-control @error('telp') is-invalid @enderror" placeholder="Masukkan telepon">
                            @error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-star me-1"></i>Point</label>
                            <input type="number" name="point" value="{{ old('point', 0) }}" class="form-control @error('point') is-invalid @enderror" placeholder="Point">
                            @error('point')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-filter me-1"></i>Jenis</label>
                            <input type="text" name="jenis" value="{{ old('jenis') }}" class="form-control @error('jenis') is-invalid @enderror" placeholder="Masukkan jenis">
                            @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-calendar-plus me-1"></i>Tanggal Daftar</label>
                            <input type="date" name="tgl_daftar" value="{{ old('tgl_daftar') }}" class="form-control @error('tgl_daftar') is-invalid @enderror">
                            @error('tgl_daftar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-calendar-xmark me-1"></i>Expired</label>
                            <input type="date" name="expired" value="{{ old('expired') }}" class="form-control @error('expired') is-invalid @enderror">
                            @error('expired')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('member.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection