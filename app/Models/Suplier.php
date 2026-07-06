<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suplier extends Model
{
    protected $fillable = ['nama_suplier', 'nomor_telepon'];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
