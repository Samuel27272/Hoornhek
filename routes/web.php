<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('klantenportaal');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('gedetineerden', 'gedetineerden.index')->name('gedetineerden.index');
});

require __DIR__ . '/settings.php';
