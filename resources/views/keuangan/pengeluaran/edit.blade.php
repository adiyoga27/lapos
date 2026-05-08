@extends('layouts.master')

@section('title', 'Edit Pengeluaran')

@section('content')
<div class="container" style="max-width:600px;">
    <div class="card">
        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="biaya_id" class="form-label">Kategori Biaya</label>
                    <select name="biaya_id" id="biaya_id" required class="form-select">
                        <option value="">-- Pilih Kategori Biaya --</option>
                        @foreach($biaya as $b)
                            <option value="{{ $b->id }}" {{ old('biaya_id', $pengeluaran->biaya_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('biaya_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="kas_id" class="form-label">Dari Kas</label>
                    <select name="kas_id" id="kas_id" required class="form-select">
                        <option value="">-- Pilih Kas --</option>
                        @foreach($kas as $k)
                            <option value="{{ $k->id }}" {{ old('kas_id', $pengeluaran->kas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kas_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $pengeluaran->jumlah) }}" required
                           class="form-control" placeholder="0">
                    @error('jumlah') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="form-control" placeholder="Catatan pengeluaran...">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
                    @error('keterangan') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($pengeluaran->tanggal)->format('Y-m-d')) }}" required class="form-control">
                    @error('tanggal') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-warning"><i class="fa-solid fa-save me-1"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection