@extends('layouts.master')

@section('title', 'Tambah Voucher')

@section('content')
<h4 class="mb-3">Tambah Voucher</h4>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <form action="{{ route('voucher.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kode" class="form-label">Kode Voucher</label>
                            <input type="text" name="kode" id="kode" value="{{ old('kode') }}" class="form-control" placeholder="VCR-001" required>
                            @error('kode') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Voucher</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control" placeholder="Nama voucher" required>
                            @error('nama') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select name="tipe" id="tipe" class="form-select" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="persen" {{ old('tipe') === 'persen' ? 'selected' : '' }}>Persen (%)</option>
                                <option value="nominal" {{ old('tipe') === 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('tipe') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" name="nilai" id="nilai" value="{{ old('nilai') }}" class="form-control" min="0" placeholder="0" required>
                            @error('nilai') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" id="tgl_mulai" value="{{ old('tgl_mulai', date('Y-m-d')) }}" class="form-control" required>
                            @error('tgl_mulai') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" value="{{ old('tgl_akhir') }}" class="form-control" required>
                            @error('tgl_akhir') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Catatan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('voucher.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection