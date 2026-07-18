<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\BatchPrintController;

Route::get('/product-print-label', function () {
    return view('livewire.product-print-label');
})->name('print');

Route::middleware(['auth'])->group(function () {
    // Rotas de impressão
    Route::get('/print/execute', [PrintController::class, 'execute'])->name('print.execute');
    Route::get('/print/preview', [PrintController::class, 'preview'])->name('print.preview');
});

