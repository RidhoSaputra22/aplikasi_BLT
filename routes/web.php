<?php

use App\Http\Controllers\HasilPsiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laporan/psi/pdf', [HasilPsiController::class, 'generatePdf'])->middleware(['auth'])->name('dashboard');
