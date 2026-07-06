<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\HrdPage;
use App\Livewire\LoginManager;

Route::get('/login', LoginManager::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    // Rute Master Tunggal Modul HRD
    Route::get('/hrd', HrdPage::class)->name('hrd');
});
