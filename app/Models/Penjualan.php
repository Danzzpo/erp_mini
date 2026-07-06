<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    // Pastikan kolom ini sesuai dengan file migration penjualans
    protected $fillable = ['pelanggan_id', 'tanggal', 'total_harga'];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
