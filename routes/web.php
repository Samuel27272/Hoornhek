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

    /** Gedetineerden routes */
    Route::get('/gedetineerden', [GedetineerdeController::class, 'index'])->name('gedetineerden.index')->middleware('rol:maatschappelijk_werker,bewaker,developer');
    Route::get('/gedetineerden/create', [GedetineerdeController::class, 'create'])->name('gedetineerden.create')->middleware('rol:bewaker,developer');
    Route::post('/gedetineerden', [GedetineerdeController::class, 'store'])->name('gedetineerden.store')->middleware('rol:bewaker,developer');
    Route::get('/gedetineerden/{gedetineerden}/edit', [GedetineerdeController::class, 'edit'])->name('gedetineerden.edit')->middleware('rol:bewaker,developer');
    Route::put('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'update'])->name('gedetineerden.update')->middleware('rol:bewaker,developer');
    Route::delete('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'destroy'])->name('gedetineerden.destroy')->middleware('rol:bewaker,developer');
    Route::get('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'show'])->name('gedetineerden.show')->middleware('rol:maatschappelijk_werker,bewaker,developer');

    Route::post('/gedetineerden/{gedetineerde}/documenten', [GedetineerdeController::class, 'uploadDocument'])->name('gedetineerden.documenten.store')->middleware('rol:maatschappelijk_werker,bewaker,developer');
    Route::delete('/gedetineerden/{gedetineerde}/documenten/{document}', [GedetineerdeController::class, 'verwijderDocument'])->name('gedetineerden.documenten.destroy')->middleware('rol:maatschappelijk_werker,bewaker,developer');

    Route::patch('/gedetineerden/{gedetineerden}/ontslaan', [GedetineerdeController::class, 'ontslaan'])->name('gedetineerden.ontslaan')->middleware('rol:bewaker,developer');
    Route::patch('/gedetineerden/{gedetineerden}/herplaatsen', [GedetineerdeController::class, 'herplaatsen'])->name('gedetineerden.herplaatsen')->middleware('rol:bewaker,developer');

    /** Zaken routes */
    Route::middleware('rol:bewaker,developer')->group(function () {
        Route::resource('zaken', ZaakController::class);
    });

    /** Cellen routes */
    Route::middleware('rol:bewaker,developer')->group(function () {
        Route::resource('cellen', CelController::class);
    });

    /** Bezoekers routes */
    Route::middleware('rol:portier,bewaker,developer')->group(function () {
        Route::resource('bezoekers', BezoekerController::class);
    });
});

require __DIR__ . '/settings.php';
