<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JemaatController extends Controller
{
    /**
     * Cetak Data Jemaat per Keluarga ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $query = KartuKeluarga::with(['jemaats', 'kepalaKeluarga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jemaats', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat_domisili', 'like', "%{$search}%");
            })->orWhere('no_kk_gereja', 'like', "%{$search}%");
        }

        $keluargas = $query->get();
        $pdf = Pdf::loadView('admin.jemaat.pdf', compact('keluargas'));
        return $pdf->download('laporan-data-jemaat-keluarga.pdf');
    }

    // 1. TAMPILKAN SEMUA DATA JEMAAT TERSTRUKTUR PER KELUARGA
    public function index(Request $request)
    {
        $query = KartuKeluarga::with(['jemaats' => function($q) {
            $q->orderByRaw("FIELD(peran_keluarga, 'Kepala Keluarga (Ayah)', 'Istri (Ibu)', 'Anak', 'Anggota Keluarga Lain')");
        }, 'kepalaKeluarga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kk_gereja', 'like', "%{$search}%")
                  ->orWhereHas('jemaats', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('alamat_domisili', 'like', "%{$search}%");
                  });
            });
        }

        $keluargas = $query->paginate(10);
        $totalJemaat = Jemaat::count();
        $totalKK = KartuKeluarga::count();

        return view('admin.jemaat.index', compact('keluargas', 'totalJemaat', 'totalKK'));
    }

    // 2. TAMPILKAN FORM TAMBAH JEMAAT
    public function create()
    {
        $kartuKeluargas = KartuKeluarga::orderBy('no_kk_gereja', 'asc')->get();
        return view('admin.jemaat.create', compact('kartuKeluargas'));
    }

    // 3. SIMPAN DATA JEMAAT BARU KE DATABASE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk_gereja'     => 'required|string|max:50',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'peran_keluarga'   => 'required|in:Kepala Keluarga (Ayah),Istri (Ibu),Anak,Anggota Keluarga Lain',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'alamat_domisili'  => 'required|string',
            'no_hp'            => 'nullable|string|max:20',
            'status_baptis'    => 'required|in:Sudah,Belum',
            'status_sidi'      => 'required|in:Sudah,Belum',
            'tanggal_baptis'   => 'nullable|date',
            'tanggal_sidi'     => 'nullable|date',
            'nama_orang_tua'   => 'nullable|string|max:255',
        ]);

        // Cari atau buat Kartu Keluarga berdasarkan No KK Gereja
        $kk = KartuKeluarga::firstOrCreate(['no_kk_gereja' => $request->no_kk_gereja]);

        $validated['kartu_keluarga_id'] = $kk->id;

        $jemaat = Jemaat::create($validated);

        // Jika perannya adalah Kepala Keluarga (Ayah), set sebagai kepala keluarga di KK
        if ($request->peran_keluarga == 'Kepala Keluarga (Ayah)') {
            $kk->update(['kepala_keluarga_id' => $jemaat->id]);
        }

        return redirect()->route('jemaat.index')->with('success', 'Anggota keluarga jemaat berhasil ditambahkan!');
    }

    // 4. TAMPILKAN FORM EDIT DATA JEMAAT
    public function edit(string $id)
    {
        $jemaat = Jemaat::with('kartuKeluarga')->findOrFail($id);
        $kartuKeluargas = KartuKeluarga::orderBy('no_kk_gereja', 'asc')->get();
        return view('admin.jemaat.edit', compact('jemaat', 'kartuKeluargas'));
    }

    // 5. PERBARUI DATA JEMAAT DI DATABASE
    public function update(Request $request, string $id)
    {
        $jemaat = Jemaat::findOrFail($id);

        $validated = $request->validate([
            'no_kk_gereja'     => 'required|string|max:50',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'peran_keluarga'   => 'required|in:Kepala Keluarga (Ayah),Istri (Ibu),Anak,Anggota Keluarga Lain',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'alamat_domisili'  => 'required|string',
            'no_hp'            => 'nullable|string|max:20',
            'status_baptis'    => 'required|in:Sudah,Belum',
            'status_sidi'      => 'required|in:Sudah,Belum',
            'tanggal_baptis'   => 'nullable|date',
            'tanggal_sidi'     => 'nullable|date',
            'nama_orang_tua'   => 'nullable|string|max:255',
        ]);

        $kk = KartuKeluarga::firstOrCreate(['no_kk_gereja' => $request->no_kk_gereja]);
        $validated['kartu_keluarga_id'] = $kk->id;

        $jemaat->update($validated);

        if ($request->peran_keluarga == 'Kepala Keluarga (Ayah)') {
            $kk->update(['kepala_keluarga_id' => $jemaat->id]);
        }

        return redirect()->route('jemaat.index')->with('success', 'Data anggota keluarga jemaat berhasil diperbarui!');
    }

    // 6. HAPUS DATA JEMAAT DARI DATABASE
    public function destroy(string $id)
    {
        $jemaat = Jemaat::findOrFail($id);
        $jemaat->delete();

        return redirect()->route('jemaat.index')->with('success', 'Data anggota keluarga jemaat berhasil dihapus!');
    }
}