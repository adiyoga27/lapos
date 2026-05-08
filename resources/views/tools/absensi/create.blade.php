@extends('layouts.master')

@section('title', 'Absen Masuk')

@section('content')
<h4 class="mb-3">Absen Masuk</h4>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Karyawan</label>
                        <select name="kode" id="kode" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawanList as $kar)
                                <option value="{{ $kar->kode }}" {{ old('kode') == $kar->kode ? 'selected' : '' }}>
                                    {{ $kar->kode }} - {{ $kar->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control" required>
                            @error('tanggal') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="masuk" class="form-label">Jam Masuk</label>
                            <input type="time" name="masuk" id="masuk" value="{{ old('masuk', date('H:i')) }}" class="form-control" required>
                            @error('masuk') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Catatan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection