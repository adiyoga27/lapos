<?php

namespace App\Models;



class Barang extends TokoModel
{
    protected $table = 'barang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'golongan',
        'subgolongan1',
        'subgolongan2',
        'satuanbeli',
        'satuan',
        'satuan2',
        'satuan3',
        'isi',
        'isi2',
        'isi3',
        'elektrik',
        'sn',
        'master',
        'tr_saldo',
        'nol_price',
        'nol_price_diskon',
        'toko',
        'gudang',
        'hpp',
        'harga_toko',
        'harga_toko2',
        'harga_toko3',
        'harga_partai',
        'harga_partai2',
        'harga_partai3',
        'harga_cabang',
        'harga_cabang2',
        'harga_cabang3',
        'diskon',
        'point',
        'point_m',
        'jenis',
        'sinkron',
        'stokmin',
        'stokmax',
        'warningstok',
        'jenis_point',
        'point_k1',
        'point_k2',
        'gambar',
        'harga_karyawan',
        'harga_member',
        'ukuran',
        'supplier',
        'pajak',
        'kode_barcode',
        'kode_barcode2',
        'kode_barcode3',
        'diskon2',
        'gambar2',
        'margin_toko',
        'margin_toko2',
        'margin_toko3',
        'margin_partai',
        'margin_partai2',
        'margin_partai3',
        'margin_cabang',
        'margin_cabang2',
        'margin_cabang3',
        'tgl_terakhir',
        'tampil',
        'diskon_beli',
        'warna',
        'sudah_ppn',
        'nilaippn',
        'expired',
        'ket',
        'ada_expired_date',
        'paket',
        'diskon_toko',
        'diskon_partai',
        'diskon_cabang',
        'komisi_spg',
        'lokasi',
        'merk',
        'cek',
        'tipe_disc_member',
        'jum_diskon_member',
        'jum_komisi_sales',
        'harga_terakhir',
        'keterangan_foto',
        'nama2',
        'nama3',
        'toko_rusak',
        'gudang_rusak',
        'stokmin_gudang',
        'stokmax_gudang',
    ];

    public function kategoriRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'kode');
    }

    public function golonganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan', 'kode');
    }

    public function golongan1Ref(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Golongan1::class, 'subgolongan1', 'kode');
    }

    public function golongan2Ref(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Golongan2::class, 'subgolongan2', 'kode');
    }

    public function supplierRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'kode');
    }

    public function ukuranRel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ukuran::class, 'ukuran', 'kode');
    }

    public function warnaRel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warna::class, 'warna', 'kode');
    }

    public function barangDiskon(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BarangDiskon::class, 'kode_barang', 'kode');
    }

    public function hrgPerGroup(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HrgPerGroup::class, 'kodebarang', 'kode');
    }

    public function hrgPerGroupSupplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HrgPerGroupSupplier::class, 'kodebarang', 'kode');
    }

    public function itemBarang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemBarang::class, 'kode_barang', 'kode');
    }

    public function itemPenjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPenjualan::class, 'kode_barang', 'kode');
    }

    public function itemPembelian(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPembelian::class, 'kode_barang', 'kode');
    }
}
