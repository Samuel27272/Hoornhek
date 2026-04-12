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

    // Gedetineerden — maatschappelijk medewerker mag alleen index en show
    Route::middleware('rol:maatschappelijk_werker,bewaker,developer')->group(function () {
        Route::resource('gedetineerden', GedetineerdeController::class)->only(['index', 'show']);
    });

    Route::middleware('rol:bewaker,developer')->group(function () {
        Route::resource('gedetineerden', GedetineerdeController::class)->except(['index', 'show']);
    });

    // Cellen — alleen bewaker en developer
    Route::middleware('rol:bewaker,developer')->group(function () {
        Route::resource('cellen', CelController::class);
    });

    // Zaken — alleen bewaker en developer
    Route::middleware('rol:bewaker,developer')->group(function () {
        Route::resource('zaken', ZaakController::class);
    });

    // Bezoekers — portier, bewaker en developer
    Route::middleware('rol:portier,bewaker,developer')->group(function () {
        Route::resource('bezoekers', BezoekerController::class);
    });
});

require __DIR__.'/settings.php';
