<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\KategoriManager;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', KategoriManager::class);
