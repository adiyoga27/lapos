@extends('layouts.master')

@section('title', 'Absen Pulang')

@section('content')
<h4 class="mb-3">Absen Pulang</h4>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Karyawan</small>
                                <p class="fw-medium mb-1">{{ $absensi->kode }} - {{ $absensi->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Tanggal</small>
                                <p class="fw-medium mb-1">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Jam Masuk</small>
                                <p class="fw-medium mb-0">{{ $absensi->masuk }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pulang" class="form-label">Jam Pulang</label>
                        <input type="time" name="pulang" id="pulang" value="{{ old('pulang', date('H:i')) }}" class="form-control" required>
                        @error('pulang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Catatan...">{{ old('keterangan', $absensi->keterangan) }}</textarea>
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