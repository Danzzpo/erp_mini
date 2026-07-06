<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pegawais', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel departemens
        $table->foreignId('departemen_id')->constrained('departemens')->onDelete('cascade');
        $table->string('nama_pegawai');
        $table->string('jabatan')->nullable();
        $table->string('email')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
