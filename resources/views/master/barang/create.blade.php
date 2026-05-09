@extends('layouts.master')

@section('title') Tambah Barang @endsection

@section('css')
<style>
    .nav-tabs .nav-link { font-size: 0.85rem; font-weight: 600; }
    .nav-tabs .nav-link.active { background-color: #0d6efd; color: #fff; border-color: #0d6efd; }
    .field-group { border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 1rem 1.25rem; margin-bottom: 1rem; }
    .field-group-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #495057; margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e9ecef; }
    .field-group .row { margin-bottom: 0; }
    .field-group .mb-3 { margin-bottom: 0.75rem !important; }
    table.pricetable th, table.pricetable td { font-size: 0.82rem; padding: 0.35rem 0.5rem; vertical-align: middle; }
    table.pricetable thead th { background-color: #f8f9fa; font-weight: 600; text-align: center; }
    .img-preview { width: 100%; max-height: 180px; border: 2px dashed #ced4da; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 0.85rem; cursor: pointer; background: #f8f9fa; }
    .img-preview:hover { border-color: #0d6efd; color: #0d6efd; }
    .img-preview img { max-height: 170px; max-width: 100%; object-fit: contain; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-plus me-1"></i>Tambah Barang</h4>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('barang.store') }}" method="POST" id="barangForm" enctype="multipart/form-data">
                    @csrf
                    <ul class="nav nav-tabs mb-3" id="barangTab" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="standard-tab" data-bs-toggle="tab" data-bs-target="#tab-standard" type="button" role="tab"><i class="fa-solid fa-file-lines me-1"></i>Standard</button></li>
                        <li class="nav-item"><button class="nav-link" id="advance-tab" data-bs-toggle="tab" data-bs-target="#tab-advance" type="button" role="tab"><i class="fa-solid fa-sliders me-1"></i>Advance</button></li>
                        <li class="nav-item"><button class="nav-link" id="member-tab" data-bs-toggle="tab" data-bs-target="#tab-member" type="button" role="tab"><i class="fa-solid fa-users me-1"></i>Member & Sales</button></li>
                        <li class="nav-item"><button class="nav-link" id="bertingkat-tab" data-bs-toggle="tab" data-bs-target="#tab-bertingkat" type="button" role="tab"><i class="fa-solid fa-layer-group me-1"></i>Harga Bertingkat</button></li>
                    </ul>

                    <div class="tab-content">
                        <!-- ==================== TAB 1: STANDARD ==================== -->
                        <div class="tab-pane fade show active" id="tab-standard" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-tags me-1"></i> Identitas Barang</div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-hashtag me-1"></i>Kode Barang <span class="text-danger">*</span></label>
                                                <input type="text" name="kode" value="{{ old('kode') }}" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode" required>
                                                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-barcode me-1"></i>Barcode</label>
                                                <input type="text" name="kode_barcode" value="{{ old('kode_barcode') }}" class="form-control @error('kode_barcode') is-invalid @enderror" placeholder="Kode barcode">
                                                @error('kode_barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-font me-1"></i>Nama Barang <span class="text-danger">*</span></label>
                                                <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama" required>
                                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-tags me-1"></i>Kategori</label>
                                                <select name="kategori" required class="form-select @error('kategori') is-invalid @enderror">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($kategori as $cat)
                                                        <option value="{{ $cat->kode }}" {{ old('kategori') == $cat->kode ? 'selected' : '' }}>{{ $cat->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-calendar-xmark me-1"></i>Expired</label>
                                                <input type="date" name="expired" value="{{ old('expired') }}" class="form-control @error('expired') is-invalid @enderror">
                                                @error('expired')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-ruler me-1"></i> Satuan dan Isi</div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan Beli</label>
                                                <input type="text" name="satuanbeli" value="{{ old('satuanbeli') }}" class="form-control @error('satuanbeli') is-invalid @enderror" placeholder="Satuan beli">
                                                @error('satuanbeli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan Jual</label>
                                                <select name="satuan" class="form-select @error('satuan') is-invalid @enderror">
                                                    <option value="">Pilih Satuan</option>
                                                    @foreach($satuan as $sat)
                                                        <option value="{{ $sat->nama }}" {{ old('satuan') == $sat->nama ? 'selected' : '' }}>{{ $sat->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-boxes-stacked me-1"></i>Isi</label>
                                                <input type="number" name="isi" value="{{ old('isi', 1) }}" class="form-control @error('isi') is-invalid @enderror" placeholder="Isi">
                                                @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-tag me-1"></i> Harga</div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-calculator me-1"></i>HPP (Harga Beli)</label>
                                                <input type="number" name="hpp" value="{{ old('hpp', 0) }}" step="0.01" class="form-control @error('hpp') is-invalid @enderror" placeholder="Harga Pokok">
                                                @error('hpp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-tag me-1"></i>Harga Jual Toko</label>
                                                <input type="number" name="harga_toko" value="{{ old('harga_toko', 0) }}" step="0.01" class="form-control @error('harga_toko') is-invalid @enderror" placeholder="Harga jual toko">
                                                @error('harga_toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-warehouse me-1"></i>Stok Toko</label>
                                                <input type="number" name="toko" value="{{ old('toko', 0) }}" class="form-control @error('toko') is-invalid @enderror" placeholder="Stok toko">
                                                @error('toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-warehouse me-1"></i>Stok Gudang</label>
                                                <input type="number" name="gudang" value="{{ old('gudang', 0) }}" class="form-control @error('gudang') is-invalid @enderror" placeholder="Stok gudang">
                                                @error('gudang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-percent me-1"></i> Diskon & Point</div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-percent me-1"></i>Diskon (%)</label>
                                                <input type="number" name="diskon" value="{{ old('diskon', 0) }}" step="0.01" class="form-control @error('diskon') is-invalid @enderror" placeholder="Diskon">
                                                @error('diskon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-star me-1"></i>Point Member</label>
                                                <input type="number" name="point" value="{{ old('point', 0) }}" class="form-control @error('point') is-invalid @enderror" placeholder="Point member">
                                                @error('point')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-user-tie me-1"></i>Point Karyawan</label>
                                                <input type="number" name="point_m" value="{{ old('point_m', 0) }}" class="form-control @error('point_m') is-invalid @enderror" placeholder="Point karyawan">
                                                @error('point_m')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-truck me-1"></i> Supplier & Pajak</div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-calendar me-1"></i>Tgl Beli Terakhir</label>
                                                <input type="text" name="tgl_terakhir" value="{{ old('tgl_terakhir') }}" class="form-control" placeholder="YYYY-MM-DD" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-square-check me-1"></i>Ada Expired Date</label>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="ada_expired_date" value="1" id="adaExpired" {{ old('ada_expired_date') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="adaExpired">Aktifkan Reminder Expired</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-truck me-1"></i>Supplier</label>
                                                <select name="supplier" class="form-select @error('supplier') is-invalid @enderror">
                                                    <option value="">Pilih Supplier</option>
                                                    @foreach($supplier as $sup)
                                                        <option value="{{ $sup->kode }}" {{ old('supplier') == $sup->kode ? 'selected' : '' }}>{{ $sup->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label"><i class="fa-solid fa-percent me-1"></i>Pajak</label>
                                                <select name="pajak" class="form-select @error('pajak') is-invalid @enderror">
                                                    <option value="">Pilih Pajak</option>
                                                    @foreach($pajak as $pjk)
                                                        <option value="{{ $pjk->kode }}" {{ old('pajak') == $pjk->kode ? 'selected' : '' }}>{{ $pjk->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('pajak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="field-group text-center">
                                        <div class="field-group-title"><i class="fa-solid fa-image me-1"></i> Gambar</div>
                                        <div class="mb-3">
                                            <div class="img-preview mb-2" id="preview1" onclick="document.getElementById('imgGambar1').click()">
                                                <span id="preview1Text"><i class="fa-solid fa-cloud-arrow-up fa-2x me-2"></i>Upload Gambar 1</span>
                                            </div>
                                            <input type="file" name="gambar" id="imgGambar1" class="d-none" accept="image/*" onchange="previewImg(this, 'preview1', 'preview1Text')">
                                        </div>
                                        <div class="mb-3">
                                            <div class="img-preview mb-2" id="preview2" onclick="document.getElementById('imgGambar2').click()">
                                                <span id="preview2Text"><i class="fa-solid fa-cloud-arrow-up fa-2x me-2"></i>Upload Gambar 2</span>
                                            </div>
                                            <input type="file" name="gambar2" id="imgGambar2" class="d-none" accept="image/*" onchange="previewImg(this, 'preview2', 'preview2Text')">
                                        </div>
                                        <div class="form-check d-flex justify-content-start mb-2">
                                            <input class="form-check-input" type="checkbox" name="nol_price" value="1" id="nolPrice" {{ old('nol_price') ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="nolPrice">Open Price <small class="text-muted">[Harga Jual Toko]</small></label>
                                        </div>
                                        <div class="form-check d-flex justify-content-start">
                                            <input class="form-check-input" type="checkbox" name="nol_price_diskon" value="1" id="nolPriceDiskon" {{ old('nol_price_diskon') ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="nolPriceDiskon">Open Price <small class="text-muted">[Diskon Jual]</small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB 2: ADVANCE ==================== -->
                        <div class="tab-pane fade" id="tab-advance" role="tabpanel">
                            <div class="field-group">
                                <div class="field-group-title"><i class="fa-solid fa-table me-1"></i> Harga & Satuan Bertingkat</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm pricetable">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th rowspan="2" style="width:40px;">NO</th>
                                                <th rowspan="2">SATUAN</th>
                                                <th rowspan="2">ISI</th>
                                                <th colspan="2">PENJUALAN TOKO</th>
                                                <th colspan="2">PENJUALAN RESELLER</th>
                                                <th rowspan="2">HARGA BELI</th>
                                                <th rowspan="2">HARGA JUAL</th>
                                                <th rowspan="2">KODE BARCODE</th>
                                                <th rowspan="2">NAMA BARANG <small class="text-muted">(OPTIONAL)</small></th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>HARGA</th>
                                                <th>MARGIN</th>
                                                <th>HARGA</th>
                                                <th>MARGIN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center fw-bold">1</td>
                                                <td>
                                                    <select name="satuan" class="form-select form-select-sm @error('satuan') is-invalid @enderror">
                                                        <option value="">-</option>
                                                        @foreach($satuan as $sat)
                                                            <option value="{{ $sat->nama }}" {{ old('satuan') == $sat->nama ? 'selected' : '' }}>{{ $sat->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="isi" value="{{ old('isi', 1) }}" class="form-control form-control-sm text-center" step="any"></td>
                                                <td><input type="number" name="harga_toko" value="{{ old('harga_toko', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_toko" value="{{ old('margin_toko', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_partai" value="{{ old('harga_partai', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_partai" value="{{ old('margin_partai', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_cabang" value="{{ old('harga_cabang', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_toko" value="{{ old('harga_toko', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="text" name="kode_barcode" value="{{ old('kode_barcode') }}" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold">2</td>
                                                <td><input type="text" name="satuan2" value="{{ old('satuan2') }}" class="form-control form-control-sm" placeholder="Satuan 2"></td>
                                                <td><input type="number" name="isi2" value="{{ old('isi2', 1) }}" class="form-control form-control-sm text-center"></td>
                                                <td><input type="number" name="harga_toko2" value="{{ old('harga_toko2', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_toko2" value="{{ old('margin_toko2', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_partai2" value="{{ old('harga_partai2', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_partai2" value="{{ old('margin_partai2', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_cabang2" value="{{ old('harga_cabang2', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td>&mdash;</td>
                                                <td><input type="text" name="kode_barcode2" value="{{ old('kode_barcode2') }}" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="nama2" value="{{ old('nama2') }}" class="form-control form-control-sm"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold">3</td>
                                                <td><input type="text" name="satuan3" value="{{ old('satuan3') }}" class="form-control form-control-sm" placeholder="Satuan 3"></td>
                                                <td><input type="number" name="isi3" value="{{ old('isi3', 1) }}" class="form-control form-control-sm text-center"></td>
                                                <td><input type="number" name="harga_toko3" value="{{ old('harga_toko3', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_toko3" value="{{ old('margin_toko3', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_partai3" value="{{ old('harga_partai3', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="margin_partai3" value="{{ old('margin_partai3', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td><input type="number" name="harga_cabang3" value="{{ old('harga_cabang3', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                <td>&mdash;</td>
                                                <td><input type="text" name="kode_barcode3" value="{{ old('kode_barcode3') }}" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="nama3" value="{{ old('nama3') }}" class="form-control form-control-sm"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted">Untuk mengaktifkan satuan ke 2 dan ke 3, isi field satuan dan isi terlebih dahulu.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-ruler-combined me-1"></i> Ukuran & Warna</div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="fa-solid fa-ruler-combined me-1"></i>Ukuran</label>
                                            <select name="ukuran" class="form-select @error('ukuran') is-invalid @enderror">
                                                <option value="">Pilih Ukuran</option>
                                                @foreach($ukuran as $uk)
                                                    <option value="{{ $uk->kode }}" {{ old('ukuran') == $uk->kode ? 'selected' : '' }}>{{ $uk->kode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label"><i class="fa-solid fa-palette me-1"></i>Warna</label>
                                            <select name="warna" class="form-select @error('warna') is-invalid @enderror">
                                                <option value="">Pilih Warna</option>
                                                @foreach($warna as $wrn)
                                                    <option value="{{ $wrn->kode }}" {{ old('warna') == $wrn->kode ? 'selected' : '' }}>{{ $wrn->kode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-location-dot me-1"></i> Merek & Lokasi</div>
                                        <div class="mb-3">
                                            <label class="form-label">Merek</label>
                                            <input type="text" name="merk" value="{{ old('merk') }}" class="form-control" placeholder="Merek barang">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Lokasi RAK</label>
                                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="form-control" placeholder="Lokasi rak">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-arrow-down me-1"></i> Stok Reminder</div>
                                        <div class="mb-3">
                                            <label class="form-label">Stok Min Toko</label>
                                            <input type="number" name="stokmin" value="{{ old('stokmin', 0) }}" class="form-control" placeholder="Stok minimum">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Stok Max Toko</label>
                                            <input type="number" name="stokmax" value="{{ old('stokmax', 0) }}" class="form-control" placeholder="Stok maksimum">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Stok Min Gudang</label>
                                            <input type="number" name="stokmin_gudang" value="{{ old('stokmin_gudang', 0) }}" class="form-control" placeholder="Stok min gudang">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-arrow-up me-1"></i> Stok Max & Rusak</div>
                                        <div class="mb-3">
                                            <label class="form-label">Stok Max Gudang</label>
                                            <input type="number" name="stokmax_gudang" value="{{ old('stokmax_gudang', 0) }}" class="form-control" placeholder="Stok max gudang">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Stok Rusak Toko</label>
                                            <input type="number" name="toko_rusak" value="{{ old('toko_rusak', 0) }}" class="form-control" placeholder="0">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Stok Rusak Gudang</label>
                                            <input type="number" name="gudang_rusak" value="{{ old('gudang_rusak', 0) }}" class="form-control" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-percent me-1"></i> Diskon Penjualan</div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Diskon Toko</label>
                                                <input type="number" name="diskon_toko" value="{{ old('diskon_toko', 0) }}" step="0.01" class="form-control" placeholder="Diskon toko">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Diskon Reseller</label>
                                                <input type="number" name="diskon_partai" value="{{ old('diskon_partai', 0) }}" step="0.01" class="form-control" placeholder="Diskon partai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-note-sticky me-1"></i> Lainnya</div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan</label>
                                            <textarea name="ket" rows="2" class="form-control" placeholder="Keterangan tambahan">{{ old('ket') }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="paket" value="1" id="paket" {{ old('paket') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paket">Jika dijual SPG dapat bonus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB 3: MEMBER & SALES ==================== -->
                        <div class="tab-pane fade" id="tab-member" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-id-card me-1"></i> Diskon Untuk Penjualan ke Member</div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tipe Diskon</label>
                                                <select name="tipe_disc_member" class="form-select">
                                                    <option value="%" {{ old('tipe_disc_member') == '%' ? 'selected' : '' }}>Persen (%)</option>
                                                    <option value="rp" {{ old('tipe_disc_member') == 'rp' ? 'selected' : '' }}>Rupiah (Rp)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jumlah Diskon</label>
                                                <input type="number" name="jum_diskon_member" value="{{ old('jum_diskon_member', 0) }}" step="0.01" class="form-control" placeholder="Jumlah diskon member">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-hand-holding-dollar me-1"></i> Komisi Untuk Sales</div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Jumlah Komisi</label>
                                                <input type="number" name="jum_komisi_sales" value="{{ old('jum_komisi_sales', 0) }}" step="0.01" class="form-control" placeholder="Komisi sales">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <div class="field-group-title"><i class="fa-solid fa-users me-1"></i> Harga Jual Per Pelanggan</div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm pricetable">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th rowspan="2">Group</th>
                                                        <th colspan="2">Penjualan Toko</th>
                                                        <th colspan="2">Penjualan Reseller</th>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th>Hrg</th>
                                                        <th>Margin</th>
                                                        <th>Hrg</th>
                                                        <th>Margin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center fw-bold">Group 1</td>
                                                        <td><input type="number" name="harga_member" value="{{ old('harga_member', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                        <td>&mdash;</td>
                                                        <td><input type="number" name="harga_karyawan" value="{{ old('harga_karyawan', 0) }}" step="0.01" class="form-control form-control-sm text-end"></td>
                                                        <td>&mdash;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB 4: HARGA BERTINGKAT ==================== -->
                        <div class="tab-pane fade" id="tab-bertingkat" role="tabpanel">
                            <div class="field-group">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fa-solid fa-ruler me-1"></i>Satuan</label>
                                        <select name="satuan_bertingkat" class="form-select">
                                            <option value="BOTOL" selected>BOTOL</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm pricetable">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Operator</th>
                                                <th>Jum 1</th>
                                                <th>Jum 2</th>
                                                <th>Pilihan</th>
                                                <th>Nilai</th>
                                                <th>Mulai</th>
                                                <th>Sampai</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-select form-select-sm">
                                                        <option value="+">+</option>
                                                        <option value="-">-</option>
                                                        <option value="*">x</option>
                                                        <option value="/">/</option>
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control form-control-sm text-center" placeholder="0"></td>
                                                <td><input type="number" class="form-control form-control-sm text-center" placeholder="0"></td>
                                                <td>
                                                    <select class="form-select form-select-sm">
                                                        <option value="hrg">Hrg</option>
                                                        <option value="disc">Disc</option>
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control form-control-sm text-end" placeholder="0"></td>
                                                <td><input type="number" class="form-control form-control-sm text-center" placeholder="0"></td>
                                                <td><input type="number" class="form-control form-control-sm text-center" placeholder="0"></td>
                                                <td><input type="text" class="form-control form-control-sm" placeholder="Keterangan"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3 p-3 rounded" style="background: #fff3cd; border: 1px solid #ffc107;">
                                    <p class="mb-1 text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i><strong>PERHATIAN!</strong> Sebelum nge set harga bertingkat, mohon benar-benar di fix kan dulu setingan satuan yang akan dipakai.</p>
                                    <p class="mb-0 text-info"><i class="fa-solid fa-circle-info me-1"></i>Pastikan satuan dan isi sudah benar sebelum mengatur harga bertingkat agar perhitungan harga tidak salah.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function previewImg(input, previewId, textId) {
    const preview = document.getElementById(previewId);
    const text = document.getElementById(textId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection