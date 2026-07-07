<?php

use Illuminate\Support\Facades\Route;

// Mengarahkan akses root langsung ke halaman HRD
Route::get('/', function () {
    return redirect('/hrd');
});

// Menggunakan Route::livewire seperti teman-temanmu (Tanpa petir!)
Route::livewire('/hrd', 'hrd-page')->name('hrd');
