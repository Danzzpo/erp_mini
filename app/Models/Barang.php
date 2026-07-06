<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $fillable = ['kategori_id', 'suplier_id', 'nama_barang', 'stok', 'harga_jual'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function suplier(): BelongsTo
    {
        return $this->belongsTo(Suplier::class);
    }
}
