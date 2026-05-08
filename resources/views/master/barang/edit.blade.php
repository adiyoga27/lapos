@extends('layouts.master')
@section('title') Edit Barang @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-pen me-1"></i>Edit Barang</h4>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('barang.update', $barang->kode) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Barang</label>
                            <input type="text" name="kode" value="{{ old('kode', $barang->kode) }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode" required>
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Barang</label>
                            <input type="text" name="nama" value="{{ old('nama', $barang->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tags me-1"></i>Kategori</label>
                            <select name="kategori" required class="form-select @error('kategori') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $cat)
                                    <option value="{{ $cat->kode }}" {{ old('kategori', $barang->kategori) == $cat->kode ? 'selected' : '' }}>{{ $cat->kode }}</option>
                                @endforeach
                            </select>
                            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-sitemap me-1"></i>Golongan</label>
                            <select name="golongan" class="form-select @error('golongan') is-invalid @enderror">
                                <option value="">Pilih Golongan</option>
                                @foreach($golongan as $gol)
                                    <option value="{{ $gol->kode }}" {{ old('golongan', $barang->golongan) == $gol->kode ? 'selected' : '' }}>{{ $gol->kode }}</option>
                                @endforeach
                            </select>
                            @error('golongan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-code-branch me-1"></i>Sub Golongan 1</label>
                            <input type="text" name="subgolongan1" value="{{ old('subgolongan1', $barang->subgolongan1) }}" class="form-control @error('subgolongan1') is-invalid @enderror" placeholder="Sub golongan 1">
                            @error('subgolongan1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-code-branch me-1"></i>Sub Golongan 2</label>
                            <input type="text" name="subgolongan2" value="{{ old('subgolongan2', $barang->subgolongan2) }}" class="form-control @error('subgolongan2') is-invalid @enderror" placeholder="Sub golongan 2">
                            @error('subgolongan2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 border-top pt-3 mt-2 mb-3">
                            <h6 class="fw-semibold"><i class="fa-solid fa-ruler me-1"></i>Satuan dan Isi</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan Beli</label>
                            <input type="text" name="satuanbeli" value="{{ old('satuanbeli', $barang->satuanbeli) }}" class="form-control @error('satuanbeli') is-invalid @enderror" placeholder="Satuan beli">
                            @error('satuanbeli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan Jual</label>
                            <select name="satuan" class="form-select @error('satuan') is-invalid @enderror">
                                <option value="">Pilih Satuan</option>
                                @foreach($satuan as $sat)
                                    <option value="{{ $sat->nama }}" {{ old('satuan', $barang->satuan) == $sat->nama ? 'selected' : '' }}>{{ $sat->nama }}</option>
                                @endforeach
                            </select>
                            @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan 2</label>
                            <input type="text" name="satuan2" value="{{ old('satuan2', $barang->satuan2) }}" class="form-control @error('satuan2') is-invalid @enderror" placeholder="Satuan 2">
                            @error('satuan2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan 3</label>
                            <input type="text" name="satuan3" value="{{ old('satuan3', $barang->satuan3) }}" class="form-control @error('satuan3') is-invalid @enderror" placeholder="Satuan 3">
                            @error('satuan3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-boxes-stacked me-1"></i>Isi</label>
                            <input type="number" name="isi" value="{{ old('isi', $barang->isi) }}" class="form-control @error('isi') is-invalid @enderror" placeholder="Isi">
                            @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-boxes-stacked me-1"></i>Isi 2</label>
                            <input type="number" name="isi2" value="{{ old('isi2', $barang->isi2) }}" class="form-control @error('isi2') is-invalid @enderror" placeholder="Isi 2">
                            @error('isi2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-boxes-stacked me-1"></i>Isi 3</label>
                            <input type="number" name="isi3" value="{{ old('isi3', $barang->isi3) }}" class="form-control @error('isi3') is-invalid @enderror" placeholder="Isi 3">
                            @error('isi3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 border-top pt-3 mt-2 mb-3">
                            <h6 class="fw-semibold"><i class="fa-solid fa-tag me-1"></i>Harga</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-calculator me-1"></i>HPP</label>
                            <input type="number" name="hpp" value="{{ old('hpp', $barang->hpp) }}" step="0.01" class="form-control @error('hpp') is-invalid @enderror" placeholder="Harga Pokok">
                            @error('hpp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tag me-1"></i>Harga Toko</label>
                            <input type="number" name="harga_toko" value="{{ old('harga_toko', $barang->harga_toko) }}" step="0.01" class="form-control @error('harga_toko') is-invalid @enderror" placeholder="Harga toko">
                            @error('harga_toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tag me-1"></i>Harga Toko 2</label>
                            <input type="number" name="harga_toko2" value="{{ old('harga_toko2', $barang->harga_toko2) }}" step="0.01" class="form-control @error('harga_toko2') is-invalid @enderror" placeholder="Harga toko 2">
                            @error('harga_toko2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tag me-1"></i>Harga Toko 3</label>
                            <input type="number" name="harga_toko3" value="{{ old('harga_toko3', $barang->harga_toko3) }}" step="0.01" class="form-control @error('harga_toko3') is-invalid @enderror" placeholder="Harga toko 3">
                            @error('harga_toko3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tags me-1"></i>Harga Partai</label>
                            <input type="number" name="harga_partai" value="{{ old('harga_partai', $barang->harga_partai) }}" step="0.01" class="form-control @error('harga_partai') is-invalid @enderror" placeholder="Harga partai">
                            @error('harga_partai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tags me-1"></i>Harga Partai 2</label>
                            <input type="number" name="harga_partai2" value="{{ old('harga_partai2', $barang->harga_partai2) }}" step="0.01" class="form-control @error('harga_partai2') is-invalid @enderror" placeholder="Harga partai 2">
                            @error('harga_partai2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-tags me-1"></i>Harga Partai 3</label>
                            <input type="number" name="harga_partai3" value="{{ old('harga_partai3', $barang->harga_partai3) }}" step="0.01" class="form-control @error('harga_partai3') is-invalid @enderror" placeholder="Harga partai 3">
                            @error('harga_partai3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-building me-1"></i>Harga Cabang</label>
                            <input type="number" name="harga_cabang" value="{{ old('harga_cabang', $barang->harga_cabang) }}" step="0.01" class="form-control @error('harga_cabang') is-invalid @enderror" placeholder="Harga cabang">
                            @error('harga_cabang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-building me-1"></i>Harga Cabang 2</label>
                            <input type="number" name="harga_cabang2" value="{{ old('harga_cabang2', $barang->harga_cabang2) }}" step="0.01" class="form-control @error('harga_cabang2') is-invalid @enderror" placeholder="Harga cabang 2">
                            @error('harga_cabang2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-building me-1"></i>Harga Cabang 3</label>
                            <input type="number" name="harga_cabang3" value="{{ old('harga_cabang3', $barang->harga_cabang3) }}" step="0.01" class="form-control @error('harga_cabang3') is-invalid @enderror" placeholder="Harga cabang 3">
                            @error('harga_cabang3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 border-top pt-3 mt-2 mb-3">
                            <h6 class="fw-semibold"><i class="fa-solid fa-percent me-1"></i>Margin & Diskon</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-percent me-1"></i>Diskon (%)</label>
                            <input type="number" name="diskon" value="{{ old('diskon', $barang->diskon) }}" step="0.01" class="form-control @error('diskon') is-invalid @enderror" placeholder="Diskon">
                            @error('diskon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-chart-line me-1"></i>Margin Toko</label>
                            <input type="number" name="margin_toko" value="{{ old('margin_toko', $barang->margin_toko) }}" step="0.01" class="form-control @error('margin_toko') is-invalid @enderror" placeholder="Margin toko">
                            @error('margin_toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-chart-line me-1"></i>Margin Partai</label>
                            <input type="number" name="margin_partai" value="{{ old('margin_partai', $barang->margin_partai) }}" step="0.01" class="form-control @error('margin_partai') is-invalid @enderror" placeholder="Margin partai">
                            @error('margin_partai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-chart-line me-1"></i>Margin Cabang</label>
                            <input type="number" name="margin_cabang" value="{{ old('margin_cabang', $barang->margin_cabang) }}" step="0.01" class="form-control @error('margin_cabang') is-invalid @enderror" placeholder="Margin cabang">
                            @error('margin_cabang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 border-top pt-3 mt-2 mb-3">
                            <h6 class="fw-semibold"><i class="fa-solid fa-barcode me-1"></i>Barcode</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-barcode me-1"></i>Kode Barcode</label>
                            <input type="text" name="kode_barcode" value="{{ old('kode_barcode', $barang->kode_barcode) }}" class="form-control @error('kode_barcode') is-invalid @enderror" placeholder="Kode barcode">
                            @error('kode_barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-barcode me-1"></i>Kode Barcode 2</label>
                            <input type="text" name="kode_barcode2" value="{{ old('kode_barcode2', $barang->kode_barcode2) }}" class="form-control @error('kode_barcode2') is-invalid @enderror" placeholder="Kode barcode 2">
                            @error('kode_barcode2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-barcode me-1"></i>Kode Barcode 3</label>
                            <input type="text" name="kode_barcode3" value="{{ old('kode_barcode3', $barang->kode_barcode3) }}" class="form-control @error('kode_barcode3') is-invalid @enderror" placeholder="Kode barcode 3">
                            @error('kode_barcode3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 border-top pt-3 mt-2 mb-3">
                            <h6 class="fw-semibold"><i class="fa-solid fa-sliders me-1"></i>Atribut & Lainnya</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-ruler-combined me-1"></i>Ukuran</label>
                            <select name="ukuran" class="form-select @error('ukuran') is-invalid @enderror">
                                <option value="">Pilih Ukuran</option>
                                @foreach($ukuran as $uk)
                                    <option value="{{ $uk->kode }}" {{ old('ukuran', $barang->ukuran) == $uk->kode ? 'selected' : '' }}>{{ $uk->kode }}</option>
                                @endforeach
                            </select>
                            @error('ukuran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-palette me-1"></i>Warna</label>
                            <select name="warna" class="form-select @error('warna') is-invalid @enderror">
                                <option value="">Pilih Warna</option>
                                @foreach($warna as $wrn)
                                    <option value="{{ $wrn->kode }}" {{ old('warna', $barang->warna) == $wrn->kode ? 'selected' : '' }}>{{ $wrn->kode }}</option>
                                @endforeach
                            </select>
                            @error('warna')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-truck me-1"></i>Supplier</label>
                            <select name="supplier" class="form-select @error('supplier') is-invalid @enderror">
                                <option value="">Pilih Supplier</option>
                                @foreach($supplier as $sup)
                                    <option value="{{ $sup->kode }}" {{ old('supplier', $barang->supplier) == $sup->kode ? 'selected' : '' }}>{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                            @error('supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-percent me-1"></i>Pajak</label>
                            <select name="pajak" class="form-select @error('pajak') is-invalid @enderror">
                                <option value="">Pilih Pajak</option>
                                @foreach($pajak as $pjk)
                                    <option value="{{ $pjk->kode }}" {{ old('pajak', $barang->pajak) == $pjk->kode ? 'selected' : '' }}>{{ $pjk->kode }}</option>
                                @endforeach
                            </select>
                            @error('pajak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-arrow-down me-1"></i>Stok Minimum</label>
                            <input type="number" name="stokmin" value="{{ old('stokmin', $barang->stokmin) }}" class="form-control @error('stokmin') is-invalid @enderror" placeholder="Stok minimum">
                            @error('stokmin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-arrow-up me-1"></i>Stok Maksimum</label>
                            <input type="number" name="stokmax" value="{{ old('stokmax', $barang->stokmax) }}" class="form-control @error('stokmax') is-invalid @enderror" placeholder="Stok maksimum">
                            @error('stokmax')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa-solid fa-calendar-xmark me-1"></i>Expired</label>
                            <input type="date" name="expired" value="{{ old('expired', $barang->expired) }}" class="form-control @error('expired') is-invalid @enderror">
                            @error('expired')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fa-solid fa-note-sticky me-1"></i>Keterangan</label>
                            <textarea name="ket" rows="3" class="form-control @error('ket') is-invalid @enderror" placeholder="Keterangan">{{ old('ket', $barang->ket) }}</textarea>
                            @error('ket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection