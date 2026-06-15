<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalPelayananController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\PelayanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WartaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// --- AREA PUBLIK (JEMAAT) ---
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/jadwal-pelayanan', [PublicController::class, 'jadwal'])->name('public.jadwal');
Route::get('/statistik', [PublicController::class, 'statistik'])->name('public.statistik');
Route::get('/warta-jemaat', [WartaController::class, 'publicIndex'])->name('public.warta');

// --- AUTENTIKASI ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- AREA ADMIN (ADMIN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('jemaat', JemaatController::class);
    Route::get('/jemaat-search', [JemaatController::class, 'search'])->name('jemaat.search');
    Route::get('/jemaat-pdf', [JemaatController::class, 'cetakPdf'])->name('jemaat.pdf');

    Route::resource('jadwal', JadwalPelayananController::class);
    Route::get('/jadwal-pdf', [JadwalPelayananController::class, 'cetakPdf'])->name('jadwal.pdf');

    Route::resource('inventaris', InventarisController::class);
    Route::get('/inventaris-pdf', [InventarisController::class, 'cetakPdf'])->name('inventaris.pdf');

    Route::resource('pelayan', PelayanController::class);
    Route::get('/pelayan-pdf', [PelayanController::class, 'cetakPdf'])->name('pelayan.pdf');

    Route::resource('warta', WartaController::class);
    Route::get('/warta-pdf', [WartaController::class, 'cetakPdf'])->name('warta.pdf');
});

// --- SISTEM ---
Route::get('/unduh-warta/{filename}', function ($filename) {
    $fullPath = 'warta/' . $filename;
    
    if (!Storage::disk('public')->exists($fullPath)) {
        \Log::error("Download gagal: File tidak ditemukan di storage/app/public/" . $fullPath);
        abort(404, 'Maaf, file Warta Jemaat tidak ditemukan di server.');
    }

    return Storage::disk('public')->download($fullPath, $filename, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
})->where('filename', '.*')->name('warta.download');
