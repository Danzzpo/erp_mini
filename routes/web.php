<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Mengarahkan akses root langsung ke halaman HRD
Route::get('/', function () {
    return redirect('/hrd');
});

// Menjadikan halaman HRD sebagai rute utama
Volt::route('/hrd', 'hrd-page')->name('hrd');
