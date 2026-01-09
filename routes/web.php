<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return redirect()->route('produits.index');
});

// Routes pour les produits
Route::prefix('produits')->name('produits.')->group(function () {
    Route::get('/', [ProduitController::class, 'index'])->name('index');
    Route::get('/create', [ProduitController::class, 'create'])->name('create');
    Route::post('/', [ProduitController::class, 'store'])->name('store');
    Route::get('/{produit}', [ProduitController::class, 'show'])->name('show'); // <-- CORRECTION ICI
    Route::get('/{produit}/edit', [ProduitController::class, 'edit'])->name('edit');
    Route::put('/{produit}', [ProduitController::class, 'update'])->name('update');
    Route::delete('/{produit}', [ProduitController::class, 'destroy'])->name('destroy');
    Route::post('/{produit}/ajuster', [ProduitController::class, 'ajusterStock'])->name('ajuster');
});

// Routes pour l'export
Route::prefix('export')->name('export.')->group(function () {
    Route::get('/excel', [ExportController::class, 'exportExcel'])->name('excel');
    Route::get('/pdf', [ExportController::class, 'exportPdf'])->name('pdf');
    Route::get('/csv', [ExportController::class, 'exportCsv'])->name('csv');
});