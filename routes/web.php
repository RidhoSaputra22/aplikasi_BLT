<?php

use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HasilPsiController;


//  redirect to admin login page
Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/laporan/psi/pdf', [HasilPsiController::class, 'generatePdf'])
    ->middleware(['auth']) // gunakan guard 'filament' jika sudah ada
    ->name('laporan.psi');
