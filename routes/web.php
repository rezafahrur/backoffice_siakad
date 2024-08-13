<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuangKelasController;

Route::get('/', function () {
    return view('home');
});

Route::get('/prodi', function () {
    return view('master.prodi.index')->name('prodi.index');
});

Route::get('/ruang-kelas', [RuangKelasController::class, 'index'])->name('kelas.index');
Route::get('/ruang-kelas/create', [RuangKelasController::class, 'create'])->name('kelas.create');
Route::post('/ruang-kelas', [RuangKelasController::class, 'store'])->name('kelas.store');
Route::get('/ruang-kelas/{kelas}/edit', [RuangKelasController::class, 'edit'])->name('kelas.edit');
Route::put('/ruang-kelas/{kelas}', [RuangKelasController::class, 'update'])->name('kelas.update');
Route::delete('/ruang-kelas/{kelas}', [RuangKelasController::class, 'destroy'])->name('kelas.destroy');
// Route::get('/ruang-kelas/show/{id}', [RuangKelasController::class, 'show'])->name('kelas.show');


