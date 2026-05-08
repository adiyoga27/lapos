@extends('layouts.master')
@section('title') Edit Pembelian @endsection
@section('content')
<div class="container" style="max-width:880px;">
    <div class="card">
        <form action="{{ route('pembelian.update', $pembelian->kode) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">No. Faktur</label>
                        <input type="text" value="{{ $pembelian->kode }}" readonly class="form-control bg-light">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="datetime-local" name="tanggal" value="{{ \Carbon\Carbon::parse($pembelian->tanggal)->format('Y-m-d\TH:i') }}" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Supplier</label>
                        <select name="supplier" required class="form-select">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($supplierList as $sup)
                                <option value="{{ $sup->kode }}" {{ $pembelian->supplier == $sup->kode ? 'selected' : '' }}>{{ $sup->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Diskon</label>
                        <input type="number" name="diskon" value="{{ old('diskon', $pembelian->diskon) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jatuh Tempo</label>
                        <input type="date" name="jt" value="{{ old('jt', $pembelian->jt ? \Carbon\Carbon::parse($pembelian->jt)->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="lunas" class="form-select">
                            <option value="1" {{ $pembelian->lunas ? 'selected' : '' }}>Lunas</option>
                            <option value="0" {{ !$pembelian->lunas ? 'selected' : '' }}>Kredit</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="form-control" placeholder="Catatan...">{{ old('keterangan', $pembelian->keterangan) }}</textarea>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection