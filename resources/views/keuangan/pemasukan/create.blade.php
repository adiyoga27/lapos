@extends('layouts.master')

@section('title', 'Tambah Pemasukan')

@section('content')
<div class="container" style="max-width:600px;">
    <div class="card">
        <form action="{{ route('pemasukan.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori Pemasukan</label>
                    <select name="kategori_id" id="kategori_id" required class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="kas_id" class="form-label">Ke Kas</label>
                    <select name="kas_id" id="kas_id" required class="form-select">
                        <option value="">-- Pilih Kas --</option>
                        @foreach($kas as $k)
                            <option value="{{ $k->id }}" {{ old('kas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kas_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required
                           class="form-control" placeholder="0">
                    @error('jumlah') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="form-control" placeholder="Catatan pemasukan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="form-control">
                    @error('tanggal') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('pemasukan.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection