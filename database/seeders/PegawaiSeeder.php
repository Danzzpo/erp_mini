<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Dede Ramdan Abatani', 'status_kontrak' => 'Tetap'],
            ['nama' => 'Muhamat Asif Abdullah', 'status_kontrak' => 'Tetap'],
            ['nama' => 'Muhammad Nur Aziz', 'status_kontrak' => 'Kontrak'],
            ['nama' => 'Siti Aminah', 'status_kontrak' => 'Magang'],
            ['nama' => 'Budi Santoso', 'status_kontrak' => 'Tetap'],
            ['nama' => 'Rina Melati', 'status_kontrak' => 'Kontrak'],
            ['nama' => 'Agus Setiawan', 'status_kontrak' => 'Magang'],
            ['nama' => 'Dewi Lestari', 'status_kontrak' => 'Tetap'],
            ['nama' => 'Fajar Pratama', 'status_kontrak' => 'Kontrak'],
            ['nama' => 'Ayu Wandira', 'status_kontrak' => 'Tetap'],
        ];

        foreach ($data as $item) {
            DB::table('pegawais')->insert([
                'nama' => $item['nama'],
                'status_kontrak' => $item['status_kontrak'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
