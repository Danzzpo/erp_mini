<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    // Ini yang menyelesaikan error MassAssignmentException
    protected $fillable = ['departemen_id', 'nama_pegawai', 'jabatan', 'email'];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }
}
