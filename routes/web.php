<?php

use App\Http\Controllers\BezoekerController;
use App\Http\Controllers\CelController;
use App\Http\Controllers\GedetineerdeController;
use App\Http\Controllers\ZaakController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('klantenportaal');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    /** Gedetineerden routes */
    Route::get('/gedetineerden', [GedetineerdeController::class, 'index'])->name('gedetineerden.index')->middleware('permission:gedetineerden.view');
    Route::get('/gedetineerden/create', [GedetineerdeController::class, 'create'])->name('gedetineerden.create')->middleware('permission:gedetineerden.create');
    Route::post('/gedetineerden', [GedetineerdeController::class, 'store'])->name('gedetineerden.store')->middleware('permission:gedetineerden.create');
    Route::get('/gedetineerden/{gedetineerden}/edit', [GedetineerdeController::class, 'edit'])->name('gedetineerden.edit')->middleware('permission:gedetineerden.edit');
    Route::put('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'update'])->name('gedetineerden.update')->middleware('permission:gedetineerden.edit');
    Route::delete('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'destroy'])->name('gedetineerden.destroy')->middleware('permission:gedetineerden.delete');
    Route::get('/gedetineerden/{gedetineerden}', [GedetineerdeController::class, 'show'])->name('gedetineerden.show')->middleware('permission:gedetineerden.view');

    Route::post('/gedetineerden/{gedetineerde}/documenten', [GedetineerdeController::class, 'uploadDocument'])->name('gedetineerden.documenten.store')->middleware('permission:documenten.upload');
    Route::delete('/gedetineerden/{gedetineerde}/documenten/{document}', [GedetineerdeController::class, 'verwijderDocument'])->name('gedetineerden.documenten.destroy')->middleware('permission:documenten.delete');

    Route::patch('/gedetineerden/{gedetineerden}/ontslaan', [GedetineerdeController::class, 'ontslaan'])->name('gedetineerden.ontslaan')->middleware('permission:gedetineerden.ontslaan');
    Route::patch('/gedetineerden/{gedetineerden}/herplaatsen', [GedetineerdeController::class, 'herplaatsen'])->name('gedetineerden.herplaatsen')->middleware('permission:gedetineerden.herplaatsen');

    /** Zaken routes */
    Route::middleware('permission:zaken.create')->group(function () {
        Route::get('/zaken/create', [ZaakController::class, 'create'])->name('zaken.create');
        Route::post('/zaken', [ZaakController::class, 'store'])->name('zaken.store');
    });
    Route::middleware('permission:zaken.view')->group(function () {
        Route::get('/zaken', [ZaakController::class, 'index'])->name('zaken.index');
        Route::get('/zaken/{zaak}', [ZaakController::class, 'show'])->name('zaken.show');
    });
    Route::middleware('permission:zaken.edit')->group(function () {
        Route::get('/zaken/{zaak}/edit', [ZaakController::class, 'edit'])->name('zaken.edit');
        Route::put('/zaken/{zaak}', [ZaakController::class, 'update'])->name('zaken.update');
    });
    Route::delete('/zaken/{zaak}', [ZaakController::class, 'destroy'])->name('zaken.destroy')->middleware('permission:zaken.delete');

    /** Cellen routes */
    Route::middleware('permission:cellen.create')->group(function () {
        Route::get('/cellen/create', [CelController::class, 'create'])->name('cellen.create');
        Route::post('/cellen', [CelController::class, 'store'])->name('cellen.store');
    });
    Route::middleware('permission:cellen.view')->group(function () {
        Route::get('/cellen', [CelController::class, 'index'])->name('cellen.index');
        Route::get('/cellen/{cel}', [CelController::class, 'show'])->name('cellen.show');
    });
    Route::middleware('permission:cellen.edit')->group(function () {
        Route::get('/cellen/{cel}/edit', [CelController::class, 'edit'])->name('cellen.edit');
        Route::put('/cellen/{cel}', [CelController::class, 'update'])->name('cellen.update');
    });
    Route::delete('/cellen/{cel}', [CelController::class, 'destroy'])->name('cellen.destroy')->middleware('permission:cellen.delete');

    /** Bezoekers routes */
    Route::middleware('permission:bezoekers.create')->group(function () {
        Route::get('/bezoekers/create', [BezoekerController::class, 'create'])->name('bezoekers.create');
        Route::post('/bezoekers', [BezoekerController::class, 'store'])->name('bezoekers.store');
    });
    Route::middleware('permission:bezoekers.view')->group(function () {
        Route::get('/bezoekers', [BezoekerController::class, 'index'])->name('bezoekers.index');
        Route::get('/bezoekers/{bezoeker}', [BezoekerController::class, 'show'])->name('bezoekers.show');
    });
    Route::middleware('permission:bezoekers.edit')->group(function () {
        Route::get('/bezoekers/{bezoeker}/edit', [BezoekerController::class, 'edit'])->name('bezoekers.edit');
        Route::put('/bezoekers/{bezoeker}', [BezoekerController::class, 'update'])->name('bezoekers.update');
    });
    Route::delete('/bezoekers/{bezoeker}', [BezoekerController::class, 'destroy'])->name('bezoekers.destroy')->middleware('permission:bezoekers.delete');

    /** Beheer routes */
    Route::middleware('permission:admin.access')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::middleware('permission:users.view')->get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::middleware('permission:users.create')->get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::middleware('permission:users.create')->post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::middleware('permission:users.edit')->get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::middleware('permission:users.edit')->put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::middleware('permission:users.delete')->delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });
});

require __DIR__ . '/settings.php';
