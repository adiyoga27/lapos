@extends('layouts.master')

@section('title', 'Bayar Hutang')

@section('content')
<div class="container" style="max-width:600px;">
    <div class="card">
        <form action="{{ route('hutang.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" id="supplier_id" required class="form-select">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="pembelian_id" class="form-label">Faktur Pembelian (Belum Lunas)</label>
                    <select name="pembelian_id" id="pembelian_id" required class="form-select">
                        <option value="">-- Pilih Faktur --</option>
                        @foreach($unpaidInvoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ old('pembelian_id') == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->kode }} - Rp {{ number_format($invoice->sisa, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('pembelian_id') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Bayar</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required
                           class="form-control" placeholder="0">
                    @error('jumlah') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="form-control">
                    @error('tanggal') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-3">
                    <label for="kas_id" class="form-label">Dari Kas</label>
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
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="form-control" placeholder="Catatan pembayaran...">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('hutang.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection