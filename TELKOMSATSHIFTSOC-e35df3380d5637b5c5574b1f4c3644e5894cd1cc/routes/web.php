<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\PetugasController;
use App\Models\Petugas;

Route::get('/', [BeritaAcaraController::class, 'showForm'])->name('welcome');
Route::post('/generate-pdf', [BeritaAcaraController::class, 'cetakPDF'])->name('generate.pdf');

// Tambahan untuk AJAX jika dibutuhkan (bukan untuk web UI)
Route::get('/api/petugas/{id}', function ($id) {
    return Petugas::findOrFail($id);
});

// Resource utama Petugas
Route::resource('petugas', PetugasController::class);


Route::get('/table', [BeritaAcaraController::class, 'index'])->name('table');
Route::resource('beritaacara', BeritaAcaraController::class);
Route::get('/table', [BeritaAcaraController::class, 'index'])->name('table');
Route::put('/table/{id}', [BeritaAcaraController::class, 'update'])->name('table.update');
Route::delete('/table/{id}', [BeritaAcaraController::class, 'destroy'])->name('table.destroy');
Route::put('/beritaacara/{id}', [BeritaAcaraController::class, 'update'])->name('beritaacara.update');
Route::get('/beritaacara/{id}/print', [BeritaAcaraController::class, 'print'])->name('beritaacara.print');



