<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelayanan;
use App\Models\Jemaat;
use App\Models\Warta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Halaman Beranda / Pengenalan
     */
    public function home()
    {
        $totalJemaat = Jemaat::count();
        $wartaTerbaru = Warta::orderBy('tanggal_terbit', 'desc')->first();
        return view('home', compact('totalJemaat', 'wartaTerbaru'));
    }

    /**
     * Halaman Jadwal Pelayanan Ibadah
     */
    public function jadwal(Request $request)
    {
        $jadwalTerbaru = JadwalPelayanan::with('pelayan')
                            ->when($request->search, function($query, $search) {
                                return $query->where(function($q) use ($search) {
                                    $q->where('nama_ibadah', 'like', "%{$search}%")
                                      ->orWhere('lokasi_ibadah', 'like', "%{$search}%");
                                });
                            })
                            ->orderBy('tanggal_waktu', 'asc')
                            ->take(20)
                            ->get();
        
        $wartaList = Warta::orderBy('tanggal_terbit', 'desc')->take(5)->get();

        return view('jadwal_publik', compact('jadwalTerbaru', 'wartaList'));
    }

    /**
     * Halaman Statistik Jemaat
     */
    public function statistik()
    {
        $totalJemaat = Jemaat::count();
        
        // Jenis Kelamin
        $pria = Jemaat::where('jenis_kelamin', 'Laki-laki')->count();
        $wanita = Jemaat::where('jenis_kelamin', 'Perempuan')->count();

        // Status Gerejawi
        $baptis = Jemaat::where('status_baptis', 'Sudah')->count();
        $sidi = Jemaat::where('status_sidi', 'Sudah')->count();

        // Kelompok Usia
        $today = Carbon::today();
        
        $anakRemaja = Jemaat::whereDate('tanggal_lahir', '>', $today->copy()->subYears(17))->count();
        $pemudaDewasa = Jemaat::whereDate('tanggal_lahir', '<=', $today->copy()->subYears(17))
                            ->whereDate('tanggal_lahir', '>', $today->copy()->subYears(50))
                            ->count();
        $lansia = Jemaat::whereDate('tanggal_lahir', '<=', $today->copy()->subYears(50))->count();

        return view('statistik', compact(
            'totalJemaat', 'pria', 'wanita', 
            'baptis', 'sidi', 
            'anakRemaja', 'pemudaDewasa', 'lansia'
        ));
    }

    /**
     * @deprecated Use home(), jadwal(), or statistik()
     */
    public function index()
    {
        return $this->home();
    }
}