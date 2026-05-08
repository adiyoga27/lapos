@extends('layouts.master')
@section('title') Edit Return Pembelian @endsection
@section('content')
<div class="container" style="max-width:720px;">
    <div class="card">
        <form action="{{ route('return_pembelian.update', $return->kode) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kode Return</label>
                        <input type="text" value="{{ $return->kode }}" readonly class="form-control bg-light">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ \Carbon\Carbon::parse($return->tanggal)->format('Y-m-d') }}" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. Faktur</label>
                        <input type="text" name="no_faktur" value="{{ old('no_faktur', $return->no_faktur) }}" required class="form-control">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Qty</label>
                        <input type="number" name="qty" value="{{ old('qty', $return->qty) }}" required min="1" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga', $return->harga) }}" required min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode Kas</label>
                        <select name="kode_kas" class="form-select">
                            <option value="">-- Pilih Kas --</option>
                            @foreach ($kasList as $kas)
                                <option value="{{ $kas->kode }}" {{ $return->kode_kas == $kas->kode ? 'selected' : '' }}>{{ $kas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Alasan</label>
                    <textarea name="alasan" rows="3" class="form-control" placeholder="Alasan return...">{{ old('alasan', $return->alasan) }}</textarea>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('return_pembelian.index') }}" class="btn btn-outline-secondary">
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