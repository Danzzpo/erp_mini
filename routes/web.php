<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\KategoriManager;
use App\Livewire\SuplierManager;
use App\Livewire\BarangManager;
use App\Livewire\LoginManager;
use App\Livewire\DepartemenManager;

Route::get('/login', LoginManager::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    // Rute untuk manajemen Kategori, Suplier, dan Barang
    Route::get('/kategori', KategoriManager::class)->name('kategori');
    Route::get('/suplier', SuplierManager::class)->name('suplier');
    Route::get('/barang', BarangManager::class)->name('barang');

    // Rute Baru HRD
    Route::get('/departemen', DepartemenManager::class)->name('departemen');
});
