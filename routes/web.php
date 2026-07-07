<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('/hrd');
});

// Panggil persis dengan emoji petirnya
Volt::route('/hrd', 'hrd-page')->name('hrd');
