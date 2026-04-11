<?php

use App\Http\Controllers\BezoekerController;
use App\Http\Controllers\CelController;
use App\Http\Controllers\GedetineerdeController;
use App\Http\Controllers\ZaakController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('klantenportaal');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    // CRUD routes for gedetineerden
    Route::resource('gedetineerden', GedetineerdeController::class);
    // CRUD routes for cellen
    Route::resource('cellen', CelController::class);
    // CRUD routes for zaken
    Route::resource('zaken', ZaakController::class);
    // CRUD routes for bezoekers
    Route::resource('bezoekers', BezoekerController::class);
});

require __DIR__.'/settings.php';
