<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\HrdPage;
use App\Livewire\LoginManager;
use Livewire\Volt\Volt;
// Nanti tambahkan use Livewire\Volt\Volt; jika Modul Gudang sudah full Volt SFC

Route::get('/login', LoginManager::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    // Rute Modul HRD (Masuk ke halaman pembungkus tab)
    Route::get('/hrd', HrdPage::class)->name('hrd');

    Volt::route('/gudang', 'gudang-page')->name('gudang');
    
    Volt::route('/penjualan', 'penjualan-page')->name('penjualan');
});
