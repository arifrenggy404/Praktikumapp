<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Inventaris;
use App\Models\JadwalPelayanan;
use App\Models\Jemaat;
use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use App\Models\Renungan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Utama Dashboard Admin
     */
    public function index()
    {
        $totalJemaat = Jemaat::count();
        $totalInventaris = Inventaris::sum('jumlah_kuantitas') ?? 0;
        $totalJadwal = JadwalPelayanan::count();

        // Statistik Fitur Baru
        $totalPendaftaran = Pendaftaran::count();
        $pendaftaranPending = Pendaftaran::where('status', 'Pending')->count();
        $totalRenungan = Renungan::count();
        $totalPengumuman = Pengumuman::count();
        $totalGaleri = Galeri::count();

        $pendaftaranTerbaru = Pendaftaran::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalJemaat', 
            'totalInventaris', 
            'totalJadwal',
            'totalPendaftaran',
            'pendaftaranPending',
            'totalRenungan',
            'totalPengumuman',
            'totalGaleri',
            'pendaftaranTerbaru'
        ));
    }
}