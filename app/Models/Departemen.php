<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departemen extends Model
{
    // Mengizinkan kolom ini diisi data
    protected $fillable = ['nama_departemen'];

    // Relasi: Satu Departemen memiliki banyak Pegawai
    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
