@extends('layouts.master')
@section('title') Tambah Bank @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-plus me-1"></i>Tambah Bank</h4>
                <a href="{{ route('bank.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('bank.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Bank</label>
                            <input type="text" name="kode" value="{{ old('kode') }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode" required>
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-money-check-dollar me-1"></i>Beban</label>
                            <input type="number" name="beban" value="{{ old('beban', 0) }}" step="0.01" class="form-control @error('beban') is-invalid @enderror" placeholder="Beban">
                            @error('beban')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('bank.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection