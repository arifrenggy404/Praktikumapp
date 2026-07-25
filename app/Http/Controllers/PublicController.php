<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\JadwalPelayanan;
use App\Models\Jemaat;
use App\Models\Pelayan;
use App\Models\PengaturanWeb;
use App\Models\Pengumuman;
use App\Models\Renungan;
use App\Models\Warta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private function getSetting()
    {
        return PengaturanWeb::first() ?? new PengaturanWeb([
            'sambutan_nama' => 'Pdt. Andreas, S.Th',
            'sambutan_jabatan' => 'Pendeta Jemaat GKS Kandara',
            'sambutan_teks' => 'Selamat datang di portal resmi GKS Jemaat Kandara.',
            'ayat_emas_teks' => 'Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka.',
            'ayat_emas_kitab' => 'Matius 18:20',
            'sejarah_gereja' => 'Gereja Kristen Sumba Jemaat Kandara.',
            'visi_gereja' => 'Menjadi Jemaat Mandiri.',
            'misi_gereja' => 'Melayani dalam kasih.',
            'alamat_gereja' => 'Jl. Kandara, Waingapu, Sumba Timur.',
            'no_wa_gereja' => '081234567890',
            'email_gereja' => 'info@gkskandara.or.id',
            'pj_komisi_anak' => 'Ibu Maria & Tim Guru SM',
            'pj_komisi_pemuda' => 'Bpk. Yohanes & Pengurus Pemuda',
            'pj_komisi_wanita' => 'Ibu Martha & Pengurus PW',
            'pj_komisi_lansia' => 'Penatua Pendamping Lansia',
        ]);
    }

    /**
     * Halaman Beranda Utama
     */
    public function home()
    {
        $setting = $this->getSetting();
        $totalJemaat = Jemaat::count();
        $wartaTerbaru = Warta::orderBy('tanggal_terbit', 'desc')->first();
        $pengumumanTerbaru = Pengumuman::orderBy('created_at', 'desc')->take(4)->get();
        $renunganTerbaru = Renungan::orderBy('tanggal', 'desc')->take(3)->get();
        $galeriTerbaru = Galeri::orderBy('tanggal_kegiatan', 'desc')->take(6)->get();
        $jadwalAkanDatang = JadwalPelayanan::orderBy('tanggal_waktu', 'asc')
                                ->where('tanggal_waktu', '>=', now())
                                ->take(3)
                                ->get();

        return view('home', compact(
            'setting',
            'totalJemaat', 
            'wartaTerbaru', 
            'pengumumanTerbaru', 
            'renunganTerbaru', 
            'galeriTerbaru',
            'jadwalAkanDatang'
        ));
    }

    /**
     * Halaman Tentang Gereja
     */
    public function tentang()
    {
        $setting = $this->getSetting();
        return view('tentang', compact('setting'));
    }

    /**
     * Halaman Pelayanan & Komisi
     */
    public function pelayanan()
    {
        $setting = $this->getSetting();
        $pelayans = Pelayan::with('jemaat')->where('is_aktif', true)->get();
        
        return view('pelayanan', compact('setting', 'pelayans'));
    }

    /**
     * Halaman Kontak & Lokasi
     */
    public function kontak()
    {
        $setting = $this->getSetting();
        return view('kontak', compact('setting'));
    }

    /**
     * Halaman Jadwal Pelayanan Ibadah
     */
    public function jadwal(Request $request)
    {
        $setting = $this->getSetting();
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

        return view('jadwal_publik', compact('setting', 'jadwalTerbaru', 'wartaList'));
    }

    /**
     * Halaman Statistik Jemaat
     */
    public function statistik()
    {
        $setting = $this->getSetting();
        $totalJemaat = Jemaat::count();
        
        $pria = Jemaat::where('jenis_kelamin', 'Laki-laki')->count();
        $wanita = Jemaat::where('jenis_kelamin', 'Perempuan')->count();

        $baptis = Jemaat::where('status_baptis', 'Sudah')->count();
        $sidi = Jemaat::where('status_sidi', 'Sudah')->count();

        $today = Carbon::today();
        
        $anakRemaja = Jemaat::whereDate('tanggal_lahir', '>', $today->copy()->subYears(17))->count();
        $pemudaDewasa = Jemaat::whereDate('tanggal_lahir', '<=', $today->copy()->subYears(17))
                            ->whereDate('tanggal_lahir', '>', $today->copy()->subYears(50))
                            ->count();
        $lansia = Jemaat::whereDate('tanggal_lahir', '<=', $today->copy()->subYears(50))->count();

        return view('statistik', compact(
            'setting',
            'totalJemaat', 'pria', 'wanita', 
            'baptis', 'sidi', 
            'anakRemaja', 'pemudaDewasa', 'lansia'
        ));
    }
}