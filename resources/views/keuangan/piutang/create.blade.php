@extends('layouts.master')
@section('title') Terima Pembayaran Piutang @endsection
@section('content')
<div class="container" style="max-width:600px;">
    <div class="card">
        <form action="{{ route('piutang.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="pelanggan_id" class="form-label">Pelanggan</label>
                    <select name="pelanggan_id" id="pelanggan_id" required class="form-select">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggan as $p)
                            <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggan_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="penjualan_id" class="form-label">Faktur Penjualan (Belum Lunas)</label>
                    <select name="penjualan_id" id="penjualan_id" required class="form-select">
                        <option value="">-- Pilih Faktur --</option>
                        @foreach($unpaidInvoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ old('penjualan_id') == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->kode }} - Rp {{ number_format($invoice->sisa, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('penjualan_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Diterima</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required
                           class="form-control" placeholder="0">
                    @error('jumlah') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="form-control">
                    @error('tanggal') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
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
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('piutang.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-1"></i> Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection