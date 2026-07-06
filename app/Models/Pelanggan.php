<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    // Pastikan kolom ini sesuai dengan file migration pelanggans
    protected $fillable = ['nama_pelanggan', 'nomor_telepon', 'alamat'];

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class);
    }
}
