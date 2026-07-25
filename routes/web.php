<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalPelayananController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\PelayanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengaturanWebController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RenunganController;
use App\Http\Controllers\WartaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// ==========================================
// 1. AREA PUBLIK (INFORMASI & JEMAAT)
// ==========================================
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PublicController::class, 'tentang'])->name('public.tentang');
Route::get('/jadwal-pelayanan', [PublicController::class, 'jadwal'])->name('public.jadwal');
Route::get('/pelayanan-komisi', [PublicController::class, 'pelayanan'])->name('public.pelayanan');
Route::get('/kontak-lokasi', [PublicController::class, 'kontak'])->name('public.kontak');
Route::get('/statistik', [PublicController::class, 'statistik'])->name('public.statistik');
Route::get('/warta-jemaat', [WartaController::class, 'publicIndex'])->name('public.warta');

// Fitur Tambahan (Pendaftaran, Renungan, Pengumuman, Galeri)
Route::get('/pendaftaran-online', [PendaftaranController::class, 'publicIndex'])->name('public.pendaftaran');
Route::post('/pendaftaran-online', [PendaftaranController::class, 'store'])->name('public.pendaftaran.store');

Route::get('/renungan-khotbah', [RenunganController::class, 'publicIndex'])->name('public.renungan');
Route::get('/papan-pengumuman', [PengumumanController::class, 'publicIndex'])->name('public.pengumuman');
Route::get('/galeri-kegiatan', [GaleriController::class, 'publicIndex'])->name('public.galeri');


// ==========================================
// 2. AUTENTIKASI ADMIN
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. AREA ADMIN (MANAGEMENT CONTROL)
// ==========================================
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data Admin
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

    // Manajemen Fitur Baru di Admin (Pendaftaran Online)
    Route::get('/pendaftaran', [PendaftaranController::class, 'adminIndex'])->name('admin.pendaftaran.index');
    Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
    Route::patch('/pendaftaran/{id}/status', [PendaftaranController::class, 'updateStatus'])->name('admin.pendaftaran.status');
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');

    // Renungan
    Route::get('/renungan', [RenunganController::class, 'adminIndex'])->name('admin.renungan.index');
    Route::post('/renungan', [RenunganController::class, 'store'])->name('admin.renungan.store');
    Route::put('/renungan/{id}', [RenunganController::class, 'update'])->name('admin.renungan.update');
    Route::delete('/renungan/{id}', [RenunganController::class, 'destroy'])->name('admin.renungan.destroy');

    // Pengumuman Digital
    Route::get('/pengumuman', [PengumumanController::class, 'adminIndex'])->name('admin.pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');

    // Galeri Foto
    Route::get('/galeri', [GaleriController::class, 'adminIndex'])->name('admin.galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    // Pengaturan Web & Profil Gereja (Dinamis Custom via Admin)
    Route::get('/pengaturan', [PengaturanWebController::class, 'index'])->name('admin.pengaturan.index');
    Route::put('/pengaturan', [PengaturanWebController::class, 'update'])->name('admin.pengaturan.update');

    // Pengubahan Username & Password Akun Login Admin
    Route::put('/profil-admin', [AuthController::class, 'updateProfilAdmin'])->name('admin.profil.update');
});


// ==========================================
// 4. UNDUH WARTA & FILE SERVING
// ==========================================
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
